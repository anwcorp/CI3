<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lokasi_model extends CI_Model
{
    private $table = 'lokasi'; 

    public function get_all()
    {
        // Select kolom explicit biar aman
        $this->db->select('LOKASI_ID, NAMA_LOKASI, LANTAI, KETERANGAN');
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('LOKASI_ID, NAMA_LOKASI, LANTAI, KETERANGAN');
        $this->db->where('LOKASI_ID', $id);
        return $this->db->get($this->table)->row();
    }

    public function insert($data)
    {
        // --- FIX: Mapping input kecil ke DB BESAR ---
        $insert_data = [
            'NAMA_LOKASI' => $data['nama_lokasi'],
            'LANTAI'      => $data['lantai'],
            'KETERANGAN'  => isset($data['keterangan']) ? $data['keterangan'] : null
        ];
        return $this->db->insert($this->table, $insert_data);
    }

    public function update($id, $data)
    {
        // --- FIX: Mapping Update juga ---
        $update_data = [
            'NAMA_LOKASI' => $data['nama_lokasi'],
            'LANTAI'      => $data['lantai'],
            'KETERANGAN'  => isset($data['keterangan']) ? $data['keterangan'] : null
        ];
        $this->db->where('LOKASI_ID', $id);
        return $this->db->update($this->table, $update_data);
    }

    public function delete($id)
    {
        $this->db->where('LOKASI_ID', $id);
        return $this->db->delete($this->table);
    }
}