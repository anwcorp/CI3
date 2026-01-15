<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjaman_model extends CI_Model
{
    private $table = 'PEMINJAMAN';
    private $detail_table = 'DETAIL_PEMINJAMAN';

    public function get_all_with_relations()
    {
        // FIX: DATE_FORMAT
        $sql = "SELECT 
                    p.PEMINJAMAN_ID,
                    p.USER_ID,
                    u.NAMA AS NAMA_PEMINJAM,
                    u.EMAIL,
                    DATE_FORMAT(p.TANGGAL_PINJAM, '%d-%m-%Y') AS TANGGAL_PINJAM,
                    DATE_FORMAT(p.TANGGAL_KEMBALI, '%d-%m-%Y') AS TANGGAL_KEMBALI,
                    p.STATUS_PEMINJAMAN
                FROM {$this->table} p
                INNER JOIN USERS u ON p.USER_ID = u.USER_ID
                ORDER BY p.PEMINJAMAN_ID DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_by_user($user_id)
    {
        // FIX: DATE_FORMAT
        $sql = "SELECT 
                    p.PEMINJAMAN_ID,
                    DATE_FORMAT(p.TANGGAL_PINJAM, '%d-%m-%Y') AS TANGGAL_PINJAM,
                    DATE_FORMAT(p.TANGGAL_KEMBALI, '%d-%m-%Y') AS TANGGAL_KEMBALI,
                    p.STATUS_PEMINJAMAN
                FROM {$this->table} p
                WHERE p.USER_ID = ?
                ORDER BY p.PEMINJAMAN_ID DESC";
        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }

    public function get_by_id_with_user($id)
    {
        $sql = "SELECT 
                    p.*,
                    u.NAMA AS NAMA_PEMINJAM,
                    u.EMAIL,
                    DATE_FORMAT(p.TANGGAL_PINJAM, '%d-%m-%Y') AS TGL_PINJAM,
                    DATE_FORMAT(p.TANGGAL_KEMBALI, '%d-%m-%Y') AS TGL_KEMBALI
                FROM {$this->table} p
                INNER JOIN USERS u ON p.USER_ID = u.USER_ID
                WHERE p.PEMINJAMAN_ID = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row();
    }

    public function get_detail_with_barang($peminjaman_id)
    {
        $sql = "SELECT 
                    dp.*,
                    b.KODE_BARANG,
                    b.NAMA_BARANG,
                    k.NAMA_KATEGORI,
                    l.NAMA_LOKASI
                FROM {$this->detail_table} dp
                INNER JOIN BARANG b ON dp.BARANG_ID = b.BARANG_ID
                INNER JOIN KATEGORI k ON b.KATEGORI_ID = k.KATEGORI_ID
                INNER JOIN LOKASI l ON b.LOKASI_ID = l.LOKASI_ID
                WHERE dp.PEMINJAMAN_ID = ?";
        $query = $this->db->query($sql, array($peminjaman_id));
        return $query->result();
    }

    public function insert($data)
    {
        // FIX TOTAL: Hapus Sequence & TO_DATE. Pakai Query Builder insert.
        $insert_data = [
            'USER_ID'           => $data['user_id'],
            'TANGGAL_PINJAM'    => $data['tanggal_pinjam'],
            'TANGGAL_KEMBALI'   => $data['tanggal_kembali'],
            'STATUS_PEMINJAMAN' => $data['status_peminjaman']
        ];

        $this->db->insert($this->table, $insert_data);
        return $this->db->insert_id(); // Ambil ID Auto Increment
    }

    public function insert_detail($data)
    {
        // FIX: Hapus Sequence DETAIL_PEMINJAMAN_SEQ
        $insert_data = [
            'PEMINJAMAN_ID' => $data['peminjaman_id'],
            'BARANG_ID'     => $data['barang_id'],
            'JUMLAH_PINJAM' => $data['jumlah_pinjam']
        ];
        return $this->db->insert($this->detail_table, $insert_data);
    }

    public function update_status($id, $status)
    {
        $this->db->where('PEMINJAMAN_ID', $id);
        return $this->db->update($this->table, ['STATUS_PEMINJAMAN' => $status]);
    }
}