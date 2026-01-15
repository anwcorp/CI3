<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log_model extends CI_Model
{
    private $table = 'log_aktivitas'; 

    public function insert_log($data)
    {
        // Ambil User ID otomatis dari session buat jaga-jaga
        $user_id = $this->session->userdata('user_id');

        // Cek tipe data yang dikirim Controller
        if (is_array($data)) {
            // KASUS 1: Inputnya Array Lengkap
            $insert_data = [
                'user_id'   => isset($data['user_id']) ? $data['user_id'] : $user_id,
                'aktivitas' => isset($data['aktivitas']) ? $data['aktivitas'] : '-',
                'waktu'     => date('Y-m-d H:i:s')
            ];
            
            // Masukkan data tambahan jika ada
            if(isset($data['peminjaman_id'])) $insert_data['peminjaman_id'] = $data['peminjaman_id'];
            if(isset($data['pengembalian_id'])) $insert_data['pengembalian_id'] = $data['pengembalian_id'];
            if(isset($data['barang_id'])) $insert_data['barang_id'] = $data['barang_id'];

        } else {
            // KASUS 2: Inputnya Cuma String (Teks Doang)
            // Contoh: insert_log("User meminjam barang")
            $insert_data = [
                'user_id'   => $user_id,
                'aktivitas' => $data, // String dijadikan isi aktivitas
                'waktu'     => date('Y-m-d H:i:s')
            ];
        }

        return $this->db->insert($this->table, $insert_data);
    }

    public function get_by_user($user_id, $limit = 10)
    {
        $this->db->select('
            log_id AS LOG_ID,
            user_id AS USER_ID,
            aktivitas AS AKTIVITAS, 
            DATE_FORMAT(waktu, "%d-%m-%Y %H:%i") as WAKTU
        ');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->order_by('waktu', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }
}