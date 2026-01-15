<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjaman extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Peminjaman_model');
        $this->load->model('Barang_model');
        $this->load->model('Log_model');
        $this->load->library('form_validation');

        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Data Peminjaman';

        $role = get_role_name();
        if (in_array($role, ['Admin', 'Petugas Inventaris', 'Kepala Bagian'])) {
            $data['peminjaman'] = $this->Peminjaman_model->get_all_with_relations();
        } else {
            $data['peminjaman'] = $this->Peminjaman_model->get_by_user(get_user_id());
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('peminjaman/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->form_validation->set_rules('tanggal_pinjam', 'Tanggal Pinjam', 'required');
        $this->form_validation->set_rules('tanggal_kembali', 'Tanggal Kembali', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Peminjaman';
            $data['barang'] = $this->Barang_model->get_available_barang();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('peminjaman/form', $data);
            $this->load->view('templates/footer');
        } else {
            $barang_ids = $this->input->post('barang_id');
            $jumlah_pinjam = $this->input->post('jumlah_pinjam');

            if (empty($barang_ids)) {
                $this->session->set_flashdata('error', 'Pilih minimal 1 barang');
                redirect('peminjaman/tambah');
            }

            // Validasi stok barang
            foreach ($barang_ids as $key => $barang_id) {
                $barang = $this->Barang_model->get_by_id($barang_id);
                if ($barang->JUMLAH < $jumlah_pinjam[$key]) {
                    $this->session->set_flashdata('error', 'Stok barang ' . $barang->NAMA_BARANG . ' tidak mencukupi');
                    redirect('peminjaman/tambah');
                }
            }

            // Mulai transaksi
            $this->db->trans_begin();

            try {
                // Insert ke tabel PEMINJAMAN
                $peminjaman_data = array(
                    'user_id'            => get_user_id(),
                    'tanggal_pinjam'     => $this->input->post('tanggal_pinjam', TRUE),
                    'tanggal_kembali'    => $this->input->post('tanggal_kembali', TRUE),
                    'status_peminjaman'  => 'Dipinjam'
                );

                $peminjaman_id = $this->Peminjaman_model->insert($peminjaman_data);

                if (!$peminjaman_id) {
                    throw new Exception('Gagal menyimpan data peminjaman');
                }

                // Insert ke tabel DETAIL_PEMINJAMAN dan update stok
                foreach ($barang_ids as $key => $barang_id) {
                    $detail_data = array(
                        'peminjaman_id' => $peminjaman_id,
                        'barang_id'     => $barang_id,
                        'jumlah_pinjam' => $jumlah_pinjam[$key]
                    );

                    if (!$this->Peminjaman_model->insert_detail($detail_data)) {
                        throw new Exception('Gagal menyimpan detail peminjaman');
                    }

                    // Update stok barang (kurangi)
                    if (!$this->Barang_model->update_stock($barang_id, $jumlah_pinjam[$key], 'subtract')) {
                        throw new Exception('Gagal mengupdate stok barang');
                    }
                }

                // Log aktivitas
                $this->Log_model->insert_log(
                    get_user_id(),
                    'Melakukan peminjaman barang',
                    $peminjaman_id
                );

                // Commit transaksi
                $this->db->trans_commit();

                // echo "User ID: " . get_user_id();
                // echo "<br>Session Data: ";
                // var_dump($this->session->userdata());
                // die();

                $this->session->set_flashdata('success', 'Peminjaman berhasil disimpan');
                redirect('peminjaman');
            } catch (Exception $e) {
                // Rollback jika terjadi error
                $this->db->trans_rollback();

                // TAMBAHKAN INI UNTUK DEBUG
                log_message('error', 'Peminjaman Error: ' . $e->getMessage());
                echo "<pre>";
                echo "ERROR MESSAGE: " . $e->getMessage() . "\n";
                echo "ERROR TRACE: " . $e->getTraceAsString();
                die();

                $this->session->set_flashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
                redirect('peminjaman/tambah');
            }
            //     catch (Exception $e) {
            //     // Rollback jika terjadi error
            //     $this->db->trans_rollback();

            //     $this->session->set_flashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            //     redirect('peminjaman/tambah');
            // }
        }
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Peminjaman';
        $data['peminjaman'] = $this->Peminjaman_model->get_by_id_with_user($id);
        $data['detail'] = $this->Peminjaman_model->get_detail_with_barang($id);

        if (!$data['peminjaman']) {
            show_404();
        }

        // Cek akses user
        $role = get_role_name();
        if (!in_array($role, ['Admin', 'Petugas Inventaris', 'Kepala Bagian'])) {
            if ($data['peminjaman']->USER_ID != get_user_id()) {
                show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Akses Ditolak');
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('peminjaman/detail', $data);
        $this->load->view('templates/footer');
    }
}