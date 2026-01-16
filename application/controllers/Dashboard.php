<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Cek login
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
        $this->load->model('Dashboard_model');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $user_id = $this->session->userdata('user_id');
        $role = get_role_name();

        // Data dasar untuk semua user
        $data['peminjaman_user'] = $this->Dashboard_model->get_peminjaman_by_user($user_id);
        $data['log_aktivitas'] = $this->Dashboard_model->get_log_by_user($user_id, 10);

        // Data tambahan untuk Admin & Petugas
        if (in_array($role, ['Administrator', 'Admin', 'Petugas Inventaris'])) {
            // Widget statistik
            $data['total_barang'] = $this->Dashboard_model->count_total_barang();
            $data['total_peminjaman_aktif'] = $this->Dashboard_model->count_peminjaman_aktif();
            $data['total_pengembalian'] = $this->Dashboard_model->count_pengembalian();
            $data['barang_stok_menipis'] = $this->Dashboard_model->get_barang_stok_menipis(5);

            // Data untuk grafik
            $data['peminjaman_bulanan'] = $this->Dashboard_model->get_peminjaman_bulanan(6);
            $data['pengembalian_bulanan'] = $this->Dashboard_model->get_pengembalian_bulanan(6);
            $data['status_peminjaman'] = $this->Dashboard_model->get_status_peminjaman();
            $data['top_barang'] = $this->Dashboard_model->get_top_barang_dipinjam(10);
            $data['barang_per_kategori'] = $this->Dashboard_model->get_barang_per_kategori();
            $data['barang_per_kondisi'] = $this->Dashboard_model->get_barang_per_kondisi();
            $data['barang_per_lokasi'] = $this->Dashboard_model->get_barang_per_lokasi();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer', $data);
    }
}