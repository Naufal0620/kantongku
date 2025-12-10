<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kategori extends CI_Model {
    
    private $table = 'categories';

    public function add_default_categories($user_id) {
        $categories = [
            [
                "user_id" => $user_id,
                "name" => "makan",
                "type" => "expense",
                "icon" => "utensils",
                "color" => "bg-yellow-100 text-yellow-600 dark:bg-yellow-600 dark:text-yellow-100"
            ],
            [
                "user_id" => $user_id,
                "name" => "jajan",
                "type" => "expense",
                "icon" => "ice-cream",
                "color" => "bg-orange-100 text-orange-600 dark:bg-orange-600 dark:text-orange-100"
            ],
            [
                "user_id" => $user_id,
                "name" => "Kos & Listrik",
                "type" => "expense",
                "icon" => "home",
                "color" => "bg-pink-100 text-pink-600 dark:bg-pink-600 dark:text-pink-100"
            ],
            [
                "user_id" => $user_id,
                "name" => "Laundry",
                "type" => "expense",
                "icon" => "tshirt",
                "color" => "bg-indigo-100 text-indigo-600 dark:bg-indigo-600 dark:text-indigo-100"
            ],
            [
                "user_id" => $user_id,
                "name" => "transportasi",
                "type" => "expense",
                "icon" => "bus",
                "color" => "bg-blue-100 text-blue-600 dark:bg-blue-600 dark:text-blue-100"
            ],
            [
                "user_id" => $user_id,
                "name" => "gaji",
                "type" => "income",
                "icon" => "sack-dollar",
                "color" => "bg-green-100 text-green-600 dark:bg-green-600 dark:text-green-100"
            ],
            [
                "user_id" => $user_id,
                "name" => "hadiah/bonus",
                "type" => "income",
                "icon" => "gift",
                "color" => "bg-red-100 text-red-600 dark:bg-red-600 dark:text-red-100"
            ],
            [
                "user_id" => $user_id,
                "name" => "kiriman ortu",
                "type" => "income",
                "icon" => "envelope-open-text",
                "color" => "bg-teal-100 text-teal-600 dark:bg-teal-600 dark:text-teal-100"
            ],
        ];

        foreach ($categories as $cat) {
            $this->insert($cat);
        }
    }

    public function get_all($user_id) {
        $this->db->order_by('id', 'DESC');
        return $this->db->get_where($this->table, ['user_id' => $user_id])->result_array();
    }
    
    public function get_grouped($user_id) {
        $all = $this->get_all($user_id);
        $data = ['expense' => [], 'income' => []];
        foreach($all as $cat) {
            $cat['name'] = html_escape($cat['name']);
            $data[$cat['type']][] = $cat;
        }
        return $data;
    }

    public function get_by_id($id)
    {
        $user_id = $this->session->userdata('user_id');
        
        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
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