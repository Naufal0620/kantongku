<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Pengaturan - KantongKu';
        $data['active_menu'] = 'pengaturan';

        $data['js'] = [
            'assets/js/pengaturan.js'
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pengaturan/index', $data);
        $this->load->view('templates/footer');
    }
}