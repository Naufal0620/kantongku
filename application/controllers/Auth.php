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

    public function forgotpassword()
    {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Lupa Password - KantongKu';
            $this->load->view('auth/forgot_password', $data);
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('users', ['email' => $email])->row_array();

            if ($user) {
                // Generate Token Random
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                // Simpan Token ke DB
                $this->db->insert('user_token', $user_token);

                // Kirim Email
                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('message', '<div class="bg-green-100 dark:bg-green-700 border border-green-400 text-green-700 dark:border-green-100 dark:text-green-100 px-4 py-3 rounded relative mb-4">Silakan cek email Anda untuk mereset password! (Cek folder Spam juga)</div>');
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('message', '<div class="bg-red-100 dark:bg-red-700 border border-red-400 text-red-700 dark:border-red-100 dark:text-red-100 px-4 py-3 rounded relative mb-4">Email tidak terdaftar atau belum diaktivasi!</div>');
                redirect('auth/forgotpassword');
            }
        }
    }

    private function _sendEmail($token, $type)
    {
        $this->load->library('email');
        
        $email_to = $this->input->post('email');
        
        $this->email->from('no-reply@kantongku.private-78.web.id', 'KantongKu Admin');
        $this->email->to($email_to);

        if ($type == 'forgot') {
            $this->email->subject('Reset Password - KantongKu');
            
            // --- DATA UNTUK VIEW EMAIL ---
            $data_email = [
                'email' => $email_to,
                'url'   => base_url() . 'auth/resetpassword?email=' . $email_to . '&token=' . urlencode($token)
            ];

            // Load View menjadi String (Parameter TRUE di akhir)
            $message = $this->load->view('auth/email_reset', $data_email, TRUE);
            
            $this->email->message($message);
        }

        if ($this->email->send()) {
            return true;
        } else {
            // Untuk debugging di localhost jika gagal
            echo $this->email->print_debugger();
            die;
        }
    }

    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('users', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                // Cek Token Expired (Contoh: 24 Jam)
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    // Token Valid: Simpan email di session sementara
                    $this->session->set_userdata('reset_email', $email);
                    $this->changePassword();
                } else {
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">Token reset password sudah kadaluarsa!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">Token reset password salah!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">Email reset password salah!</div>');
            redirect('auth');
        }
    }

    // 4. UBAH PASSWORD
    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password Baru', 'trim|required|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Ulangi Password', 'trim|required|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Ubah Password - KantongKu';
            $this->load->view('auth/change_password', $data);
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            // Update Password User
            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('users');

            // Hapus Token (agar tidak bisa dipakai lagi)
            $this->db->delete('user_token', ['email' => $email]);

            // Hapus session sementara
            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('message', '<div class="bg-green-100 dark:bg-green-700 border border-green-400 text-green-700 dark:border-green-100 dark:text-green-100 px-4 py-3 rounded relative mb-4">Password berhasil diubah! Silakan login.</div>');
            redirect('auth');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}