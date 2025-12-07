<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_transaksi extends CI_Model {

    // 1. Ambil Total Saldo, Pemasukan, Pengeluaran
    public function get_saldo($user_id) {
        $income = $this->db->select_sum('amount')->from('transactions')
                           ->join('categories', 'categories.id = transactions.category_id')
                           ->where(['transactions.user_id' => $user_id, 'categories.type' => 'income'])
                           ->get()->row()->amount;
        
        $expense = $this->db->select_sum('amount')->from('transactions')
                            ->join('categories', 'categories.id = transactions.category_id')
                            ->where(['transactions.user_id' => $user_id, 'categories.type' => 'expense'])
                            ->get()->row()->amount;

        return [
            'total' => $income - $expense,
            'income' => (int)$income,
            'expense' => (int)$expense
        ];
    }

    // 2. Data untuk Kalender & List Transaksi (Group by Date)
    public function get_calendar_data($user_id, $month, $year) {
        $this->db->select('transactions.*, categories.name as cat_name, categories.type, categories.icon, categories.color');
        $this->db->from('transactions');
        $this->db->join('categories', 'categories.id = transactions.category_id');
        $this->db->where('transactions.user_id', $user_id);
        
        // Filter berdasarkan parameter
        $this->db->where('MONTH(date)', $month);
        $this->db->where('YEAR(date)', $year);
        
        $query = $this->db->get()->result_array();

        $grouped = [];
        foreach ($query as $row) {
            $day = (int)date('j', strtotime($row['date']));
            $row['note'] = html_escape($row['note']);
            $grouped[$day][] = $row;
        }
        return $grouped;
    }

    // 3. Data untuk Grafik Perbandingan Mingguan (4 Minggu Terakhir)
    public function get_weekly_chart($user_id) {
        // Query agak kompleks untuk membagi data per minggu
        $query = $this->db->query("
            SELECT 
                WEEK(date, 1) - WEEK(DATE_SUB(date, INTERVAL DAYOFMONTH(date)-1 DAY), 1) + 1 as week_num,
                categories.type,
                SUM(amount) as total
            FROM transactions
            JOIN categories ON categories.id = transactions.category_id
            WHERE transactions.user_id = ? 
            AND MONTH(date) = MONTH(CURRENT_DATE())
            AND YEAR(date) = YEAR(CURRENT_DATE())
            GROUP BY week_num, categories.type
        ", [$user_id])->result_array();

        // Format data agar siap pakai di ChartJS
        $result = [
            'labels' => ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'],
            'income' => [0, 0, 0, 0, 0],
            'expense' => [0, 0, 0, 0, 0]
        ];

        foreach ($query as $row) {
            $idx = $row['week_num'] - 1; // Array index mulai dari 0
            if (isset($result[$row['type']][$idx])) {
                $result[$row['type']][$idx] = (int)$row['total'];
            }
        }
        return $result;
    }

    // 4. Hitung Burn Rate (Rata-rata pengeluaran harian)
    public function get_burn_rate($user_id) {
        $query = $this->db->query("
            SELECT SUM(amount) as total, COUNT(DISTINCT date) as days_active 
            FROM transactions 
            JOIN categories ON categories.id = transactions.category_id
            WHERE transactions.user_id = ? 
            AND categories.type = 'expense'
            AND MONTH(date) = MONTH(CURRENT_DATE())
        ", [$user_id])->row_array();

        $total_expense = $query['total'] ?? 0;
        // Jika belum ada data hari ini, anggap 1 hari
        $days_passed = (int)date('j'); 
        
        return $days_passed > 0 ? ($total_expense / $days_passed) : 0;
    }

    // Ambil semua transaksi di bulan & tahun tertentu untuk user ini
    public function get_monthly_data($user_id, $month, $year)
    {
        // Pilih semua kolom transaksi, DAN kolom type dari tabel categories
        $this->db->select('transactions.*, categories.type'); 
        
        $this->db->from('transactions');
        
        // Hubungkan transactions.category_id dengan categories.id
        $this->db->join('categories', 'transactions.category_id = categories.id');
        
        // Filter User
        $this->db->where('transactions.user_id', $user_id);
        
        // Filter Tanggal
        $this->db->where('MONTH(transactions.date)', $month);
        $this->db->where('YEAR(transactions.date)', $year);
        
        // Eksekusi query
        return $this->db->get()->result_array();
    }

    public function add_transaction($data) {
        return $this->db->insert('transactions', $data);
    }

    public function update_transaction($id, $data) {
        $this->db->where('id', $id);
        $this->db->where('user_id', $this->session->userdata('user_id')); // Security check
        return $this->db->update('transactions', $data);
    }

    public function delete_transaction($id) {
        $this->db->where('id', $id);
        $this->db->where('user_id', $this->session->userdata('user_id')); // Security check
        return $this->db->delete('transactions');
    }
}