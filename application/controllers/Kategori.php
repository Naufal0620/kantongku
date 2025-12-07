<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load Model & Library yang diperlukan
        $this->load->model('M_kategori');
        $this->load->library('form_validation');
        
        // Cek Login (Standar Dashboard)
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Kategori - KantongKu';
        $user_id = $this->session->userdata('user_id');
        
        // Mengambil semua data kategori (model sudah disesuaikan sebelumnya)
        $data['kategori'] = $this->M_kategori->get_all($user_id);
        
        // Data pendukung tampilan
        $data['active_menu'] = 'kategori'; // Untuk highlight di Sidebar

        $data['js'] = [
            'assets/js/kategori.js'
        ];

        // Load Views (Urutan Template)
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data); // Membuka tag <main>
        $this->load->view('kategori/index', $data);    // Konten Inti
        $this->load->view('templates/footer');         // Menutup tag </main>
    }

    public function tambah()
    {
        $this->form_validation->set_rules('name', 'Nama Kategori', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('type', 'Jenis', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan ke index dengan error (opsional: pakai flashdata error)
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Gagal menambah kategori. Pastikan input benar.</div>');
            redirect('kategori');
        } else {
            $data = [
                'user_id' => $this->session->userdata('user_id'),
                'name'    => $this->input->post('name', true),
                'type'    => $this->input->post('type', true),
                'icon'    => $this->input->post('icon', true),
                'color'   => $this->input->post('color', true)
            ];

            $this->M_kategori->insert($data);
            $this->session->set_flashdata('pesan', '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert"><strong class="font-bold">Berhasil!</strong> <span class="block sm:inline">Kategori baru ditambahkan.</span></div>');
            redirect('kategori');
        }
    }

    public function edit($id)
    {
        // Validasi form sama seperti tambah
        $this->form_validation->set_rules('name', 'Nama Kategori', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('type', 'Jenis', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('kategori');
        } else {
            $data_update = [
                'name'    => $this->input->post('name', true),
                'type'    => $this->input->post('type', true),
                'icon'    => $this->input->post('icon', true),
                'color'   => $this->input->post('color', true)
            ];

            // Pastikan ID valid dan milik user (handled by Model logic usually, but here ID is primary)
            $this->M_kategori->update($id, $data_update);
            $this->session->set_flashdata('pesan', '<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert"><strong class="font-bold">Update Berhasil!</strong> <span class="block sm:inline">Data kategori diperbarui.</span></div>');
            redirect('kategori');
        }
    }

    public function hapus($id)
    {
        $this->M_kategori->delete($id);
        $this->session->set_flashdata('pesan', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert"><strong class="font-bold">Dihapus!</strong> <span class="block sm:inline">Kategori telah dihapus.</span></div>');
        redirect('kategori');
    }
}