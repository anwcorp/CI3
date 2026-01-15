<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    private $user_data; // Simpan data user di sini

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_model');
        $this->load->model('Log_model');
        $this->load->library('form_validation');

        // 1. Cek Login & Role Manual (Ganti check_role)
        is_logged_in(); // Helper bawaan
        
        $role = get_role_name();
        // Izinkan Administrator juga biar aman
        if (!in_array($role, ['Administrator', 'Admin', 'Petugas Inventaris'])) {
            redirect('dashboard'); // Tendang kalau bukan admin/petugas
        }

        // 2. Ambil Data User buat Topbar (Anti Error)
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
        $data['title'] = 'Data Kategori';
        $data['kategori'] = $this->Kategori_model->get_all();
        
        // Inject User Data
        $data['user'] = $this->user_data;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data); // Kirim data ke sidebar
        $this->load->view('templates/topbar', $data);  // Kirim data ke topbar
        $this->load->view('kategori/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Kategori';
            $data['user'] = $this->user_data; // Inject User Data

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kategori/form');
            $this->load->view('templates/footer');
        } else {
            $insert_data = array(
                'nama_kategori' => $this->input->post('nama_kategori', TRUE),
                'keterangan'    => $this->input->post('keterangan', TRUE)
            );

            if ($this->Kategori_model->insert($insert_data)) {
                // Log aktivitas
                $this->Log_model->insert_log([
                    'user_id' => get_user_id(),
                    'aktivitas' => 'Menambah kategori: ' . $insert_data['nama_kategori']
                ]);

                $this->session->set_flashdata('success', 'Data kategori berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data kategori');
            }
            redirect('kategori');
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Kategori';
            $data['kategori'] = $this->Kategori_model->get_by_id($id);
            $data['user'] = $this->user_data; // Inject User Data

            if (!$data['kategori']) {
                show_404();
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kategori/form', $data);
            $this->load->view('templates/footer');
        } else {
            $update_data = array(
                'nama_kategori' => $this->input->post('nama_kategori', TRUE),
                'keterangan'    => $this->input->post('keterangan', TRUE)
            );

            if ($this->Kategori_model->update($id, $update_data)) {
                // Log aktivitas
                $this->Log_model->insert_log([
                    'user_id' => get_user_id(),
                    'aktivitas' => 'Mengubah kategori ID: ' . $id
                ]);

                $this->session->set_flashdata('success', 'Data kategori berhasil diubah');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah data kategori');
            }
            redirect('kategori');
        }
    }

    public function hapus($id)
    {
        $kategori = $this->Kategori_model->get_by_id($id);

        if (!$kategori) {
            show_404();
        }

        if ($this->Kategori_model->delete($id)) {
            // Log aktivitas
            $this->Log_model->insert_log([
                'user_id' => get_user_id(),
                'aktivitas' => 'Menghapus kategori: ' . $kategori->NAMA_KATEGORI
            ]);

            $this->session->set_flashdata('success', 'Data kategori berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data kategori');
        }
        redirect('kategori');
    }
}