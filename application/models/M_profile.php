<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_profile extends CI_Model {

    private $table = 'users';

    // Ambil data user yang sedang login
    public function get_user($id)
    {
        // Hindari mengambil password hash untuk ditampilkan
        $this->db->select('id, name, email, avatar'); 
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    // Update data profil
    public function update_profile($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
}