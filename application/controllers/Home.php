<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index()
    {
        $data['title'] = 'KantongKu - Kelola Keuanganmu';
        $data['is_login'] = $this->session->userdata('user_id'); // Cek status login

        $this->load->view('templates/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('templates/footer');
    }

    public function panduan()
    {
        $data['title'] = 'Panduan Penggunaan - KantongKu';
        $data['is_login'] = $this->session->userdata('user_id');

        $this->load->view('templates/header', $data);
        $this->load->view('home/panduan', $data);
        $this->load->view('templates/footer');
    }
}