<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_profile');
        $this->load->library('form_validation');
        
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Profil Saya - KantongKu';
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_profile->get_user($user_id);
        
        // LOGIKA PENENTUAN AVATAR (Display)
        // Cek apakah avatar mengandung titik (.) yang menandakan ekstensi file
        if (strpos($data['user']['avatar'], '.') !== false) {
            $data['avatar_url'] = base_url('uploads/profile/' . $data['user']['avatar']);
            $data['is_custom'] = true; // Flag penanda ini foto upload
        } else {
            // Jika tidak ada titik, berarti ini Seed DiceBear
            $data['avatar_url'] = 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $data['user']['avatar'];
            $data['is_custom'] = false;
        }

        $data['js'] = ['assets/js/profile.js'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('profile/index', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $user_id = $this->session->userdata('user_id');
        $user = $this->M_profile->get_user($user_id); // Ambil data lama untuk referensi hapus gambar

        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|trim|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('pesan', '<div class="bg-red-100 border border-red-400 text-red-700 dark:bg-red-900/50 dark:border-red-600 dark:text-red-300 px-4 py-3 rounded relative mb-4 transition-colors duration-300">Gagal! '.validation_errors().'</div>');
            redirect('profile');
        } else {
            $data_update = [
                'name' => htmlspecialchars($this->input->post('name', true)),
            ];

            // 1. CEK APAKAH ADA FILE YANG DIUPLOAD?
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $target_dir = './uploads/profile/';

                if (!is_dir($target_dir)) {
                    // Buat folder baru. 
                    // 0777 = Hak akses penuh (Read/Write/Execute)
                    // true = Recursive
                    mkdir($target_dir, 0777, true); 
                }
                
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '5120'; // 5MB
                $config['upload_path']   = $target_dir;
                $config['file_name']     = 'pro_' . time(); // Rename agar unik

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    // Hapus gambar lama jika ada (dan bukan default/seed)
                    $old_image = $user['avatar'];
                    if (strpos($old_image, '.') !== false) {
                        unlink(FCPATH . 'uploads/profile/' . $old_image);
                    }

                    // Simpan nama file baru ke database
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('avatar', $new_image);
                } else {
                    $this->session->set_flashdata('pesan', '<div class="bg-red-100 border border-red-400 text-red-700 dark:bg-red-900/50 dark:border-red-600 dark:text-red-300 px-4 py-3 rounded relative mb-4 transition-colors duration-300">' . $this->upload->display_errors() . '</div>');
                    redirect('profile');
                }
            }
            // 2. JIKA TIDAK UPLOAD, CEK APAKAH GANTI SEED (DiceBear)?
            // Kita cek input hidden 'avatar_mode' yang akan kita buat di JS
            else if ($this->input->post('avatar_mode') == 'seed') {
                $seed = $this->input->post('avatar_seed');
                
                // Jika sebelumnya pakai foto, hapus fotonya
                if (strpos($user['avatar'], '.') !== false) {
                    unlink(FCPATH . 'uploads/profile/' . $user['avatar']);
                }
                
                $this->db->set('avatar', $seed);
            }

            // Cek Password
            $new_password = $this->input->post('password');
            if (!empty($new_password)) {
                $this->db->set('password', password_hash($new_password, PASSWORD_DEFAULT));
            }

            $this->M_profile->update_profile($user_id, $data_update);
            
            // Update session nama
            $this->session->set_userdata('name', $data_update['name']);

            $this->session->set_flashdata('pesan', '
            <div class="bg-green-100 border border-green-400 text-green-700 dark:bg-green-900/50 dark:border-green-600 dark:text-green-300 px-4 py-3 rounded relative mb-4 transition-colors duration-300">
                <strong class="font-bold">Berhasil!</strong> Profil diperbarui.
            </div>');
            redirect('profile');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}