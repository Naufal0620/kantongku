<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) redirect('auth');
        $this->load->model('M_transaksi');
        $this->load->model('M_kategori');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['title'] = 'Dashboard - KantongKu';
        
        $data['saldo'] = $this->M_transaksi->get_saldo($user_id);
        $data['categories'] = $this->M_kategori->get_grouped($user_id);
        
        // UPDATE INI: Kirim Bulan & Tahun Saat Ini
        $currentMonth = date('m');
        $currentYear = date('Y');
        $data['calendar_data'] = $this->M_transaksi->get_calendar_data($user_id, $currentMonth, $currentYear);
        
        $data['chart_data'] = $this->M_transaksi->get_weekly_chart($user_id);
        $data['burn_rate'] = $this->M_transaksi->get_burn_rate($user_id);
        
        $data['js'] = ['assets/js/dashboard.js'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer', $data);
    }

    // --- TAMBAHAN BARU: Endpoint AJAX untuk Ganti Bulan ---
    public function get_calendar_json() {
        $user_id = $this->session->userdata('user_id');
        $month = $this->input->get('month');
        $year = $this->input->get('year');

        // Ambil data baru
        $data = $this->M_transaksi->get_calendar_data($user_id, $month, $year);
        
        // Kirim sebagai JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function simpan_transaksi() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('amount', 'Nominal', 'required|numeric');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required');

        if ($this->form_validation->run()) {
            $data = [
                'user_id' => $this->session->userdata('user_id'),
                'category_id' => $this->input->post('category_id'),
                'amount' => $this->input->post('amount'),
                'date' => $this->input->post('date'),
                'note' => $this->input->post('note')
            ];
            $this->M_transaksi->add_transaction($data);
            $this->session->set_flashdata('message', 'Transaksi berhasil disimpan!');
        }
        redirect('dashboard');
    }

    public function update_transaksi() {
        $id = $this->input->post('id');
        $data = [
            'category_id' => $this->input->post('category_id'),
            'amount' => $this->input->post('amount'),
            'date' => $this->input->post('date'),
            'note' => $this->input->post('note')
        ];
        $this->M_transaksi->update_transaction($id, $data);
        $this->session->set_flashdata('message', 'Transaksi berhasil diperbarui!');
        redirect('dashboard');
    }

    public function hapus_transaksi($id) {
        $this->M_transaksi->delete_transaction($id);
        $this->session->set_flashdata('message', 'Transaksi berhasil dihapus!');
        redirect('dashboard');
    }
}