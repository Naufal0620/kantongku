<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_profile');
        $this->load->library('form_validation');
        
        // Cek Login
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Profil Saya - KantongKu';
        $user_id = $this->session->userdata('user_id');
        
        // Ambil data user
        $data['user'] = $this->M_profile->get_user($user_id);
        $data['active_menu'] = 'profile'; // Untuk highlight Sidebar (Perlu update sidebar.php nanti)

        // Load External JS
        $data['js'] = [
            'assets/js/profile.js'
        ];

        // Load Views
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('profile/index', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $user_id = $this->session->userdata('user_id');

        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|trim|max_length[100]', [
            'max_length' => 'Nama terlalu panjang (maks 100 karakter)'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|max_length[255]', [
            'max_length' => 'Password terlalu panjang'
        ]);
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('pesan', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">' . validation_errors() . '</div>');
            redirect('profile');
        } else {
            // Siapkan data update
            $data = [
                'name'   => $this->input->post('name', true),
                'avatar' => $this->input->post('avatar', true) // Simpan seed avatar
            ];

            // Cek apakah password diisi (ingin diubah)
            $new_password = $this->input->post('password');
            if (!empty($new_password)) {
                // Hash password baru (sesuaikan dengan metode hash login kamu, misal password_hash)
                $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
            }

            $this->M_profile->update_profile($user_id, $data);
            
            // Update session nama jika perlu
            $this->session->set_userdata('name', $data['name']);

            $this->session->set_flashdata('pesan', '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">Profil berhasil diperbarui!</div>');
            redirect('profile');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}