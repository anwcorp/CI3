<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kondisi_model extends CI_Model
{
    private $table = 'kondisi'; 

    public function get_all()
    {
        // Ambil kolom eksplisit biar View gak bingung (HURUF BESAR)
        $this->db->select('KONDISI_ID, NAMA_KONDISI, KETERANGAN');
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('KONDISI_ID, NAMA_KONDISI, KETERANGAN');
        $this->db->where('KONDISI_ID', $id);
        return $this->db->get($this->table)->row();
    }

    public function insert($data)
    {
        // --- FIX: Mapping data input (kecil) ke Kolom DB (BESAR) ---
        $insert_data = [
            'NAMA_KONDISI' => $data['nama_kondisi'],
            'KETERANGAN'   => isset($data['keterangan']) ? $data['keterangan'] : null
        ];
        return $this->db->insert($this->table, $insert_data);
    }

    public function update($id, $data)
    {
        // --- FIX: Mapping Update juga ---
        $update_data = [
            'NAMA_KONDISI' => $data['nama_kondisi'],
            'KETERANGAN'   => isset($data['keterangan']) ? $data['keterangan'] : null
        ];
        $this->db->where('KONDISI_ID', $id);
        return $this->db->update($this->table, $update_data);
    }

    public function delete($id)
    {
        $this->db->where('KONDISI_ID', $id);
        return $this->db->delete($this->table);
    }
}