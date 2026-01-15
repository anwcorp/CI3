<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kondisi extends CI_Controller
{
    private $user_data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kondisi_model');
        $this->load->model('Log_model');
        $this->load->library('form_validation');

        // Fix Role Check & Topbar User
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
        $data['title'] = 'Data Kondisi';
        $data['kondisi'] = $this->Kondisi_model->get_all();
        $data['user'] = $this->user_data;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kondisi/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nama_kondisi', 'Nama Kondisi', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Kondisi';
            $data['user'] = $this->user_data;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kondisi/form');
            $this->load->view('templates/footer');
        } else {
            $insert_data = array(
                'nama_kondisi' => $this->input->post('nama_kondisi', TRUE),
                'keterangan'   => $this->input->post('keterangan', TRUE)
            );

            if ($this->Kondisi_model->insert($insert_data)) {
                $this->Log_model->insert_log([
                    'user_id' => get_user_id(),
                    'aktivitas' => 'Menambah kondisi: ' . $insert_data['nama_kondisi']
                ]);
                $this->session->set_flashdata('success', 'Data kondisi berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data kondisi');
            }
            redirect('kondisi');
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('nama_kondisi', 'Nama Kondisi', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Kondisi';
            $data['kondisi'] = $this->Kondisi_model->get_by_id($id);
            $data['user'] = $this->user_data;

            if (!$data['kondisi']) show_404();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kondisi/form', $data);
            $this->load->view('templates/footer');
        } else {
            $update_data = array(
                'nama_kondisi' => $this->input->post('nama_kondisi', TRUE),
                'keterangan'   => $this->input->post('keterangan', TRUE)
            );

            if ($this->Kondisi_model->update($id, $update_data)) {
                $this->Log_model->insert_log([
                    'user_id' => get_user_id(),
                    'aktivitas' => 'Mengubah kondisi ID: ' . $id
                ]);
                $this->session->set_flashdata('success', 'Data kondisi berhasil diubah');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah data kondisi');
            }
            redirect('kondisi');
        }
    }

    public function hapus($id)
    {
        $kondisi = $this->Kondisi_model->get_by_id($id);
        if (!$kondisi) show_404();

        if ($this->Kondisi_model->delete($id)) {
            $this->Log_model->insert_log([
                'user_id' => get_user_id(),
                'aktivitas' => 'Menghapus kondisi: ' . $kondisi->NAMA_KONDISI
            ]);
            $this->session->set_flashdata('success', 'Data kondisi berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data kondisi');
        }
        redirect('kondisi');
    }
}