<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model');
        $this->load->model('Peminjaman_model');
        $this->load->model('Pengembalian_model');
        $this->load->model('Log_model');

        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';

        // --- FIX MAPPING: Terjemahkan Database ke View ---
        $user_id = get_user_id();
        
        // Ambil data mentah dari database
        $db_user = $this->db->get_where('USERS', ['USER_ID' => $user_id])->row_array();

        // Kita buat array baru yang kuncinya sesuai permintaan View (topbar.php)
        $data['user'] = [
            'name'  => $db_user['NAMA'],      // DB punya 'NAMA', View minta 'name'
            'image' => 'default.jpg',         // DB gak punya foto, kita kasih dummy biar gak error
            'role_id' => $db_user['ROLE_ID']  // Simpan juga role ID kalau butuh
        ];
        // ------------------------------------------------

        // Inisialisasi Nilai Default
        $data['total_barang'] = 0;
        $data['total_peminjaman_aktif'] = 0;
        $data['total_pengembalian'] = 0;
        $data['barang_stok_menipis'] = [];

        // Cek Role
        $role_name = get_role_name(); 

        // Statistik HANYA untuk Admin & Petugas
        if (in_array($role_name, ['Admin', 'Petugas Inventaris'])) {
            $data['total_barang'] = $this->Barang_model->count_all();
            
            $this->db->where('STATUS_PEMINJAMAN', 'Dipinjam');
            $data['total_peminjaman_aktif'] = $this->db->count_all_results('PEMINJAMAN');

            $data['total_pengembalian'] = $this->db->count_all('PENGEMBALIAN');
            $data['barang_stok_menipis'] = $this->Barang_model->get_stok_menipis();
        }

        // Data untuk SEMUA User
        $data['peminjaman_user'] = $this->Peminjaman_model->get_by_user($user_id);
        $data['log_aktivitas'] = $this->Log_model->get_by_user($user_id, 10);

        // Load View
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data); 
        $this->load->view('templates/topbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
}