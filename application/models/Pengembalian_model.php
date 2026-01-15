<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengembalian_model extends CI_Model
{
    private $table = 'PENGEMBALIAN';
    private $detail_table = 'DETAIL_PENGEMBALIAN';

    public function get_all_with_relations()
    {
        $sql = "SELECT 
                    pg.PENGEMBALIAN_ID,
                    pg.PEMINJAMAN_ID,
                    pm.USER_ID,
                    u.NAMA AS NAMA_PEMINJAM,
                    DATE_FORMAT(pg.TANGGAL_DIKEMBALIKAN, '%d-%m-%Y') AS TANGGAL_DIKEMBALIKAN,
                    pg.CATATAN
                FROM {$this->table} pg
                INNER JOIN PEMINJAMAN pm ON pg.PEMINJAMAN_ID = pm.PEMINJAMAN_ID
                INNER JOIN USERS u ON pm.USER_ID = u.USER_ID
                ORDER BY pg.PENGEMBALIAN_ID DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_by_id_with_relations($id)
    {
        $sql = "SELECT 
                    pg.*,
                    pm.USER_ID,
                    u.NAMA AS NAMA_PEMINJAM,
                    u.EMAIL,
                    DATE_FORMAT(pg.TANGGAL_DIKEMBALIKAN, '%d-%m-%Y') AS TGL_DIKEMBALIKAN
                FROM {$this->table} pg
                INNER JOIN PEMINJAMAN pm ON pg.PEMINJAMAN_ID = pm.PEMINJAMAN_ID
                INNER JOIN USERS u ON pm.USER_ID = u.USER_ID
                WHERE pg.PENGEMBALIAN_ID = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row();
    }

    public function get_detail_with_barang($pengembalian_id)
    {
        $sql = "SELECT 
                    dp.*,
                    b.KODE_BARANG,
                    b.NAMA_BARANG,
                    k.NAMA_KONDISI AS KONDISI_SETELAH_NAMA
                FROM {$this->detail_table} dp
                INNER JOIN BARANG b ON dp.BARANG_ID = b.BARANG_ID
                INNER JOIN KONDISI k ON dp.KONDISI_SETELAH = k.KONDISI_ID
                WHERE dp.PENGEMBALIAN_ID = ?";
        $query = $this->db->query($sql, array($pengembalian_id));
        return $query->result();
    }

    public function insert($data)
    {
        // FIX: MySQL Style Insert
        $insert_data = [
            'PEMINJAMAN_ID'        => $data['peminjaman_id'],
            'TANGGAL_DIKEMBALIKAN' => $data['tanggal_dikembalikan'],
            'CATATAN'              => $data['catatan']
        ];
        $this->db->insert($this->table, $insert_data);
        return $this->db->insert_id();
    }

    public function insert_detail($data)
    {
        // FIX: MySQL Style Insert Detail
        $insert_data = [
            'PENGEMBALIAN_ID' => $data['pengembalian_id'],
            'BARANG_ID'       => $data['barang_id'],
            'JUMLAH_KEMBALI'  => $data['jumlah_kembali'],
            'KONDISI_SETELAH' => $data['kondisi_setelah']
        ];
        return $this->db->insert($this->detail_table, $insert_data);
    }
}