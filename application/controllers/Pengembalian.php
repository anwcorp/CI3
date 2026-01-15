<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengembalian extends CI_Controller
{
    private $user_data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengembalian_model');
        $this->load->model('Peminjaman_model');
        $this->load->model('Barang_model');
        $this->load->model('Kondisi_model');
        $this->load->model('Log_model');
        $this->load->library('form_validation');

        // Fix Role & User Data
        is_logged_in(); 
        $role = get_role_name();
        if (!in_array($role, ['Administrator', 'Admin', 'Petugas Inventaris'])) {
            redirect('dashboard'); 
        }

        $user_id = get_user_id();
        $db_user = $this->db->get_where('USERS', ['USER_ID' => $user_id])->row_array();

        $this->user_data = [
            'name'  => isset($db_user['NAMA']) ? $db_user['NAMA'] : 'User',
            'image' => 'default.jpg',
            'role_id' => isset($db_user['ROLE_ID']) ? $db_user['ROLE_ID'] : 0
        ];
    }

    public function index()
    {
        $data['title'] = 'Data Pengembalian';
        $data['pengembalian'] = $this->Pengembalian_model->get_all_with_relations();
        $data['user'] = $this->user_data;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengembalian/index', $data);
        $this->load->view('templates/footer');
    }

    public function proses($peminjaman_id)
    {
        $this->form_validation->set_rules('tanggal_dikembalikan', 'Tanggal Dikembalikan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Proses Pengembalian';
            $data['peminjaman'] = $this->Peminjaman_model->get_by_id_with_user($peminjaman_id);
            $data['detail'] = $this->Peminjaman_model->get_detail_with_barang($peminjaman_id);
            $data['kondisi'] = $this->Kondisi_model->get_all();
            $data['user'] = $this->user_data;

            if (!$data['peminjaman'] || $data['peminjaman']->STATUS_PEMINJAMAN != 'Dipinjam') {
                $this->session->set_flashdata('error', 'Data peminjaman tidak valid');
                redirect('pengembalian');
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengembalian/form', $data);
            $this->load->view('templates/footer');
        } else {
            $jumlah_kembali = $this->input->post('jumlah_kembali');
            $kondisi_setelah = $this->input->post('kondisi_setelah');
            $detail_peminjaman_ids = $this->input->post('detail_peminjaman_id');
            $barang_ids = $this->input->post('barang_id');

            $this->db->trans_begin();

            try {
                $pengembalian_data = array(
                    'peminjaman_id'        => $peminjaman_id,
                    'tanggal_dikembalikan' => $this->input->post('tanggal_dikembalikan', TRUE),
                    'catatan'              => $this->input->post('catatan', TRUE)
                );

                $pengembalian_id = $this->Pengembalian_model->insert($pengembalian_data);

                if (!$pengembalian_id) {
                    throw new Exception('Gagal menyimpan data pengembalian');
                }

                foreach ($detail_peminjaman_ids as $key => $detail_id) {
                    $detail_data = array(
                        'pengembalian_id' => $pengembalian_id,
                        'barang_id'       => $barang_ids[$key],
                        'jumlah_kembali'  => $jumlah_kembali[$key],
                        'kondisi_setelah' => $kondisi_setelah[$key]
                    );

                    if (!$this->Pengembalian_model->insert_detail($detail_data)) {
                        throw new Exception('Gagal menyimpan detail pengembalian');
                    }

                    if (!$this->Barang_model->update_stock($barang_ids[$key], $jumlah_kembali[$key], 'add')) {
                        throw new Exception('Gagal mengupdate stok barang');
                    }
                }

                if (!$this->Peminjaman_model->update_status($peminjaman_id, 'Selesai')) { // Ganti ke 'Selesai' biar standar
                    throw new Exception('Gagal mengupdate status peminjaman');
                }

                // FIX: Log Aktivitas sesuai model baru kita
                $this->Log_model->insert_log([
                    'user_id' => get_user_id(),
                    'aktivitas' => 'Memproses pengembalian ID: ' . $pengembalian_id,
                    'peminjaman_id' => $peminjaman_id,
                    'pengembalian_id' => $pengembalian_id
                ]);

                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Pengembalian berhasil diproses');
                redirect('pengembalian');
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
                redirect('pengembalian/proses/' . $peminjaman_id);
            }
        }
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Pengembalian';
        $data['pengembalian'] = $this->Pengembalian_model->get_by_id_with_relations($id);
        $data['detail'] = $this->Pengembalian_model->get_detail_with_barang($id);
        $data['user'] = $this->user_data;

        if (!$data['pengembalian']) show_404();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengembalian/detail', $data);
        $this->load->view('templates/footer');
    }
}