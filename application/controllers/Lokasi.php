<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lokasi extends CI_Controller
{
    // Variabel buat nyimpen data user biar Topbar gak error
    private $user_data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Lokasi_model');
        $this->load->model('Log_model');
        $this->load->library('form_validation');

        // 1. Cek Login & Role Manual (Anti Error check_role)
        is_logged_in(); // Helper bawaan CI (pastikan auth_helper diload)
        
        $role = get_role_name();
        // Izinkan Administrator juga
        if (!in_array($role, ['Administrator', 'Admin', 'Petugas Inventaris'])) {
            redirect('dashboard'); 
        }

        // 2. Ambil Data User buat Topbar (Wajib ada!)
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
        $data['title'] = 'Data Lokasi';
        $data['lokasi'] = $this->Lokasi_model->get_all();
        
        // Inject User Data ke View
        $data['user'] = $this->user_data;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data); // Kirim data ke sidebar
        $this->load->view('templates/topbar', $data);  // Kirim data ke topbar
        $this->load->view('lokasi/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nama_lokasi', 'Nama Lokasi', 'required|trim');
        $this->form_validation->set_rules('lantai', 'Lantai', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Lokasi';
            $data['user'] = $this->user_data; // Inject User Data

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('lokasi/form');
            $this->load->view('templates/footer');
        } else {
            $insert_data = array(
                'nama_lokasi' => $this->input->post('nama_lokasi', TRUE),
                'lantai'      => $this->input->post('lantai', TRUE),
                'keterangan'  => $this->input->post('keterangan', TRUE)
            );

            if ($this->Lokasi_model->insert($insert_data)) {
                // Log aktivitas
                $this->Log_model->insert_log([
                    'user_id' => get_user_id(),
                    'aktivitas' => 'Menambah lokasi: ' . $insert_data['nama_lokasi']
                ]);
                $this->session->set_flashdata('success', 'Data lokasi berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data lokasi');
            }
            redirect('lokasi');
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('nama_lokasi', 'Nama Lokasi', 'required|trim');
        $this->form_validation->set_rules('lantai', 'Lantai', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Lokasi';
            $data['lokasi'] = $this->Lokasi_model->get_by_id($id);
            $data['user'] = $this->user_data; // Inject User Data

            if (!$data['lokasi']) {
                show_404();
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('lokasi/form', $data);
            $this->load->view('templates/footer');
        } else {
            $update_data = array(
                'nama_lokasi' => $this->input->post('nama_lokasi', TRUE),
                'lantai'      => $this->input->post('lantai', TRUE),
                'keterangan'  => $this->input->post('keterangan', TRUE)
            );

            if ($this->Lokasi_model->update($id, $update_data)) {
                // Log aktivitas
                $this->Log_model->insert_log([
                    'user_id' => get_user_id(),
                    'aktivitas' => 'Mengubah lokasi ID: ' . $id
                ]);
                $this->session->set_flashdata('success', 'Data lokasi berhasil diubah');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah data lokasi');
            }
            redirect('lokasi');
        }
    }

    public function hapus($id)
    {
        $lokasi = $this->Lokasi_model->get_by_id($id);

        if (!$lokasi) {
            show_404();
        }

        if ($this->Lokasi_model->delete($id)) {
            // Log aktivitas
            $this->Log_model->insert_log([
                'user_id' => get_user_id(),
                'aktivitas' => 'Menghapus lokasi: ' . $lokasi->NAMA_LOKASI
            ]);
            $this->session->set_flashdata('success', 'Data lokasi berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data lokasi');
        }
        redirect('lokasi');
    }
}