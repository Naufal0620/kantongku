<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_profile extends CI_Model {

    private $table = 'users';

    public function get_user($id)
    {
        $this->db->select('id, name, email, avatar'); 
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    public function update_profile($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
}