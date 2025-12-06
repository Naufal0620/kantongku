<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load model yang baru diganti namanya
        $this->load->model('M_kategori');
        $this->load->library('form_validation');
        
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Daftar Kategori';
        $user_id = $this->session->userdata('user_id');
        
        // Panggil method 'get_all' yang sudah ada di model kamu
        $data['kategori'] = $this->M_kategori->get_all($user_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('kategori/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Kategori';

        $this->form_validation->set_rules('name', 'Nama Kategori', 'required|trim');
        $this->form_validation->set_rules('type', 'Jenis', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('kategori/tambah');
            $this->load->view('templates/footer');
        } else {
            $data = [
                'user_id' => $this->session->userdata('user_id'),
                'name'    => $this->input->post('name', true),
                'type'    => $this->input->post('type', true),
                'icon'    => $this->input->post('icon', true),
                'color'   => $this->input->post('color', true)
            ];

            $this->M_kategori->insert($data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Kategori berhasil ditambahkan!</div>');
            // Redirect ke controller Kategori
            redirect('kategori');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Kategori';
        $data['kategori'] = $this->M_kategori->get_by_id($id);

        if(!$data['kategori']){ redirect('kategori'); }

        $this->form_validation->set_rules('name', 'Nama Kategori', 'required|trim');
        $this->form_validation->set_rules('type', 'Jenis', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('kategori/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $data_update = [
                'name'    => $this->input->post('name', true),
                'type'    => $this->input->post('type', true),
                'icon'    => $this->input->post('icon', true),
                'color'   => $this->input->post('color', true)
            ];

            $this->M_kategori->update($id, $data_update);
            $this->session->set_flashdata('pesan', '<div class="alert alert-info">Kategori berhasil diperbarui!</div>');
            redirect('kategori');
        }
    }

    public function hapus($id)
    {
        $cek = $this->M_kategori->get_by_id($id);
        if($cek) {
            $this->M_kategori->delete($id);
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Kategori berhasil dihapus!</div>');
        }
        redirect('kategori');
    }
}