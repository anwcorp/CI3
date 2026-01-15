<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Log_model');
        $this->load->library('form_validation');
        $this->load->helper('security');
    }

    public function index()
    {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login');
        } else {
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->Auth_model->get_user_by_email($email);

            // Logika Login Final (Sudah Support Bcrypt)
            if ($user && password_verify($password, $user->PASSWORD)) {
                
                // Cek status user
                if ($user->STATUS_USER != 'Aktif') {
                    $this->session->set_flashdata('error', 'Akun Anda tidak aktif');
                    redirect('auth');
                }

                // Set session
                $session_data = array(
                    'user_id'   => $user->USER_ID,
                    'nama'      => $user->NAMA,
                    'email'     => $user->EMAIL,
                    'role_id'   => $user->ROLE_ID,
                    'nama_role' => isset($user->NAMA_ROLE) ? $user->NAMA_ROLE : 'User', // Antisipasi error
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($session_data);

                // Log aktivitas (Pastikan tabel LOG_AKTIVITAS sudah ada)
                // Jika masih error table log, comment dulu bagian ini
                 $this->Log_model->insert_log(
                    $user->USER_ID,
                    'Login'
                );

                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Email atau password salah');
                redirect('auth');
            }
        }
    }

    public function logout()
    {
        $user_id = $this->session->userdata('user_id');

        // Log aktivitas
        if ($user_id) {
            $this->Log_model->insert_log($user_id, 'Logout');
        }

        $this->session->sess_destroy();
        redirect('auth');
    }
}