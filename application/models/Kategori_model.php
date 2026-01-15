<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori_model extends CI_Model
{
    // Sesuaikan nama tabel (DB lu pake huruf kecil 'kategori' kan?)
    private $table = 'kategori'; 

    public function get_all()
    {
        // Paksa select kolom jadi Huruf Besar biar View gak bingung
        $this->db->select('KATEGORI_ID, NAMA_KATEGORI, KETERANGAN');
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('KATEGORI_ID, NAMA_KATEGORI, KETERANGAN');
        $this->db->where('KATEGORI_ID', $id);
        return $this->db->get($this->table)->row();
    }

    public function insert($data)
    {
        // --- FIX: Mapping data Input (kecil) ke Kolom DB (BESAR) ---
        $insert_data = [
            'NAMA_KATEGORI' => $data['nama_kategori'],
            'KETERANGAN'    => isset($data['keterangan']) ? $data['keterangan'] : null
        ];
        return $this->db->insert($this->table, $insert_data);
    }

    public function update($id, $data)
    {
        // --- FIX: Mapping Update juga ---
        $update_data = [
            'NAMA_KATEGORI' => $data['nama_kategori'],
            'KETERANGAN'    => isset($data['keterangan']) ? $data['keterangan'] : null
        ];
        $this->db->where('KATEGORI_ID', $id);
        return $this->db->update($this->table, $update_data);
    }

    public function delete($id)
    {
        $this->db->where('KATEGORI_ID', $id);
        return $this->db->delete($this->table);
    }
}