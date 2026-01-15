<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    // Variabel buat nyimpen data user biar bisa dipake di semua fungsi
    private $user_data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model');
        $this->load->model('Kategori_model');
        $this->load->model('Lokasi_model');
        $this->load->model('Kondisi_model');
        $this->load->library('form_validation');
        
        is_logged_in(); 

        // --- FIX: Ambil Data User Sekali Saja di Sini ---
        $user_id = get_user_id();
        $db_user = $this->db->get_where('USERS', ['USER_ID' => $user_id])->row_array();

        // Mapping Data untuk Topbar
        $this->user_data = [
            'name'  => isset($db_user['NAMA']) ? $db_user['NAMA'] : 'User',
            'image' => 'default.jpg', // Dummy image
            'role_id' => isset($db_user['ROLE_ID']) ? $db_user['ROLE_ID'] : 0
        ];
        // ------------------------------------------------
    }

    public function index()
    {
        $data['title'] = 'Data Barang';
        $data['barang'] = $this->Barang_model->get_all_with_relations();
        
        // Inject Data User ke $data
        $data['user'] = $this->user_data;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data); // Jangan lupa kirim $data ke sidebar juga
        $this->load->view('templates/topbar', $data);
        $this->load->view('barang/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required');
        $this->form_validation->set_rules('lokasi_id', 'Lokasi', 'required');
        $this->form_validation->set_rules('kondisi_id', 'Kondisi', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
        $this->form_validation->set_rules('tanggal_perolehan', 'Tanggal Perolehan', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Data Barang';
            
            $data['kategori'] = $this->Kategori_model->get_all();
            $data['lokasi']   = $this->Lokasi_model->get_all();
            $data['kondisi']  = $this->Kondisi_model->get_all();

            // Inject Data User
            $data['user'] = $this->user_data;

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('barang/form', $data);
            $this->load->view('templates/footer');
        } else {
            // Logic Generate Kode Barang
            $kategori_id = $this->input->post('kategori_id');
            $kode_barang = $this->Barang_model->generate_kode_barang($kategori_id);

            $data_insert = [
                'kode_barang'       => $kode_barang,
                'nama_barang'       => $this->input->post('nama_barang'),
                'kategori_id'       => $this->input->post('kategori_id'),
                'lokasi_id'         => $this->input->post('lokasi_id'),
                'kondisi_id'        => $this->input->post('kondisi_id'),
                'jumlah'            => $this->input->post('jumlah'),
                'tanggal_perolehan' => $this->input->post('tanggal_perolehan'),
                'status_barang'     => 'Tersedia'
            ];

            $this->Barang_model->insert($data_insert);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data barang berhasil ditambahkan!</div>');
            redirect('barang');
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Edit Data Barang';
            
            $data['barang'] = $this->Barang_model->get_by_id($id);
            $data['kategori'] = $this->Kategori_model->get_all();
            $data['lokasi']   = $this->Lokasi_model->get_all();
            $data['kondisi']  = $this->Kondisi_model->get_all();

            // Inject Data User
            $data['user'] = $this->user_data;

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('barang/form', $data);
            $this->load->view('templates/footer');
        } else {
            $data_update = [
                'nama_barang'       => $this->input->post('nama_barang'),
                'kategori_id'       => $this->input->post('kategori_id'),
                'lokasi_id'         => $this->input->post('lokasi_id'),
                'kondisi_id'        => $this->input->post('kondisi_id'),
                'jumlah'            => $this->input->post('jumlah'),
                'tanggal_perolehan' => $this->input->post('tanggal_perolehan'),
                'status_barang'     => $this->input->post('status_barang')
            ];

            $this->Barang_model->update($id, $data_update);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data barang berhasil diupdate!</div>');
            redirect('barang');
        }
    }

    public function hapus($id)
    {
        $this->Barang_model->delete($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data barang berhasil dihapus!</div>');
        redirect('barang');
    }
    
    // Fungsi Cleanup Duplikat (Buat Admin)
    public function cleanup_duplicates()
    {
        // Pastikan hanya admin yang bisa akses
        if (get_role_name() != 'Administrator' && get_role_name() != 'Admin') {
            redirect('barang');
        }

        // Panggil model untuk hapus duplikat
        // (Pastikan fungsi remove_duplicates ada di Model Barang)
        $affected_rows = $this->Barang_model->remove_duplicates();
        
        if ($affected_rows > 0) {
            $this->session->set_flashdata('success', "Berhasil membersihkan $affected_rows data duplikat.");
        } else {
            $this->session->set_flashdata('success', "Tidak ditemukan data duplikat.");
        }
        
        redirect('barang');
    }
}