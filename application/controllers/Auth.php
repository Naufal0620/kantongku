<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_auth');
        $this->load->model('M_kategori');
    }

    public function index() {
        if ($this->session->userdata('user_id')) redirect('dashboard');
        
        $data['title'] = 'Login - KantongKu';

        $data['js'] = [
            'assets/js/auth.js'
        ];

        $this->load->view('auth/login', $data);
    }

    public function process_login() {
        // Set response header ke JSON
        header('Content-Type: application/json');

        // 1. Validasi Input
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            // Jika validasi gagal, kirim error
            echo json_encode([
                'status' => 'error',
                'message' => validation_errors() // Mengembalikan string error HTML
            ]);
            return;
        }

        // 2. Cek Credential
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->M_auth->get_user_by_email($email);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Login Sukses
                $data = [
                    'user_id' => $user['id'],
                    'email' => $user['email'],
                    'name' => $user['name']
                ];
                $this->session->set_userdata($data);

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Login berhasil! Mengalihkan...',
                    'redirect_url' => base_url('dashboard')
                ]);
            } else {
                // Password Salah
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Password salah!'
                ]);
            }
        } else {
            // Email Tidak Ditemukan
            echo json_encode([
                'status' => 'error',
                'message' => 'Email tidak terdaftar!'
            ]);
        }
    }

    public function registration() {
        if ($this->session->userdata('user_id')) redirect('dashboard');

        $data['title'] = 'Daftar Akun - KantongKu';

        $data['js'] = [
            'assets/js/auth.js'
        ];

        $this->load->view('auth/register', $data);
    }

    public function process_register() {
        header('Content-Type: application/json');

        // 1. Validasi Input
        $this->form_validation->set_rules('name', 'Nama', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            'is_unique' => 'Email ini sudah terdaftar, silakan login!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'min_length' => 'Password minimal 3 karakter!'
        ]);

        if ($this->form_validation->run() == false) {
            echo json_encode([
                'status' => 'error',
                'message' => validation_errors() // Return error dalam format HTML string
            ]);
            return;
        }

        // 2. Simpan ke Database
        $this->M_auth->register_user();

        // Buat kategori default
        $user = $this->M_auth->get_user_by_email($this->input->post('email', true));
        $this->M_kategori->add_default_categories($user["id"]);

        // 3. Kirim Respon Sukses
        echo json_encode([
            'status' => 'success',
            'message' => 'Akun berhasil dibuat! Silakan login.',
            'redirect_url' => base_url('auth') // Redirect ke halaman login setelah sukses
        ]);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}