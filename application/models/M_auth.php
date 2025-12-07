<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

    public function get_user_by_email($email) {
        return $this->db->get_where('users', ['email' => $email])->row_array();
    }

    public function register_user() {
        $data = [
            'name' => htmlspecialchars($this->input->post('name', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'avatar' => 'thpoam'
        ];
        $this->db->insert('users', $data);
    }
}