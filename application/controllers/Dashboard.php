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

    public function get_chart_data()
    {
        // Ambil input dari AJAX
        $month = $this->input->post('month');
        $year  = $this->input->post('year');
        $user_id = $this->session->userdata('user_id');

        // Ambil data mentah dari Model
        $raw_data = $this->M_transaksi->get_monthly_data($user_id, $month, $year);

        // Siapkan wadah untuk 5 minggu
        // Week 1: Tgl 1-7, Week 2: 8-14, Week 3: 15-21, Week 4: 22-28, Week 5: 29-31
        $weeks = [
            1 => ['income' => 0, 'expense' => 0],
            2 => ['income' => 0, 'expense' => 0],
            3 => ['income' => 0, 'expense' => 0],
            4 => ['income' => 0, 'expense' => 0],
            5 => ['income' => 0, 'expense' => 0],
        ];

        foreach ($raw_data as $t) {
            $day = date('j', strtotime($t['date'])); // Ambil tanggal (1-31)
            
            // Tentukan masuk minggu ke berapa
            if ($day <= 7) $w = 1;
            elseif ($day <= 14) $w = 2;
            elseif ($day <= 21) $w = 3;
            elseif ($day <= 28) $w = 4;
            else $w = 5;

            // Jumlahkan nominal
            if ($t['type'] == 'income') {
                $weeks[$w]['income'] += $t['amount'];
            } else {
                $weeks[$w]['expense'] += $t['amount'];
            }
        }

        // Format data untuk Chart.js
        $response = [
            'labels'  => ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'],
            'income'  => [],
            'expense' => []
        ];

        foreach ($weeks as $w) {
            $response['income'][] = $w['income'];
            $response['expense'][] = $w['expense'];
        }

        // Return JSON
        echo json_encode($response);
    }

    public function simpan_transaksi() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('amount', 'Nominal', 'required|numeric|less_than_equal_to[100000000]');

        if ($this->form_validation->run()) {
            $data = [
                'user_id' => $this->session->userdata('user_id'),
                'category_id' => $this->input->post('category_id'),
                'amount' => $this->input->post('amount'),
                'date' => $this->input->post('date'),
                'note' => $this->input->post('note', TRUE)
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
            'note' => $this->input->post('note', TRUE)
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