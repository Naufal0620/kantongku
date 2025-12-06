<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kategori extends CI_Model {
    
    // Nama tabel
    private $table = 'categories';

    // --- KODE LAMA (Disesuaikan sedikit dengan $this->table) ---

    public function get_all($user_id) {
        // Saya tambahkan order_by agar data terbaru muncul di atas
        $this->db->order_by('id', 'DESC');
        return $this->db->get_where($this->table, ['user_id' => $user_id])->result_array();
    }
    
    // Helper untuk memisahkan income/expense (Dipakai Dashboard)
    public function get_grouped($user_id) {
        $all = $this->get_all($user_id);
        $data = ['expense' => [], 'income' => []];
        foreach($all as $cat) {
            // Karena return array, akses index menggunakan ['key']
            $data[$cat['type']][] = $cat; 
        }
        return $data;
    }

    // --- TAMBAHAN BARU UNTUK FITUR KATEGORI (CRUD) ---

    // Ambil 1 data spesifik (Untuk Edit) - Return Array
    public function get_by_id($id)
    {
        $user_id = $this->session->userdata('user_id');
        
        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id); // Security: Cek punya user sendiri
        return $this->db->get($this->table)->row_array(); 
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}