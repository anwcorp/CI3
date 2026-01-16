<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    // ==================== STATISTIK DASAR ====================

    public function count_total_barang()
    {
        return $this->db->count_all('BARANG');
    }

    public function count_peminjaman_aktif()
    {
        return $this->db->where('STATUS_PEMINJAMAN', 'Dipinjam')->count_all_results('PEMINJAMAN');
    }

    public function count_pengembalian()
    {
        return $this->db->count_all('PENGEMBALIAN');
    }

    public function get_barang_stok_menipis($limit = 5)
    {
        return $this->db->select('b.*, k.NAMA_KATEGORI, l.NAMA_LOKASI')
            ->from('BARANG b')
            ->join('KATEGORI k', 'k.KATEGORI_ID = b.KATEGORI_ID', 'left')
            ->join('LOKASI l', 'l.LOKASI_ID = b.LOKASI_ID', 'left')
            ->where('b.JUMLAH <=', $limit)
            ->order_by('b.JUMLAH', 'ASC')
            ->get()
            ->result();
    }

    // ==================== DATA USER ====================

    public function get_peminjaman_by_user($user_id, $limit = 10)
    {
        return $this->db->select('*')
            ->from('PEMINJAMAN')
            ->where('USER_ID', $user_id)
            ->order_by('TANGGAL_PINJAM', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    public function get_log_by_user($user_id, $limit = 10)
    {
        return $this->db->select('*')
            ->from('LOG_AKTIVITAS')
            ->where('USER_ID', $user_id)
            ->order_by('WAKTU', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    // ==================== GRAFIK: PEMINJAMAN & PENGEMBALIAN BULANAN ====================

    public function get_peminjaman_bulanan($bulan = 6)
    {
        $sql = "SELECT 
                    DATE_FORMAT(TANGGAL_PINJAM, '%b %Y') AS BULAN,
                    COUNT(*) AS TOTAL
                FROM PEMINJAMAN
                WHERE TANGGAL_PINJAM >= DATE_SUB(CURDATE(), INTERVAL " . (int)$bulan . " MONTH)
                GROUP BY DATE_FORMAT(TANGGAL_PINJAM, '%Y-%m')
                ORDER BY DATE_FORMAT(TANGGAL_PINJAM, '%Y-%m') ASC";
        
        return $this->db->query($sql)->result();
    }

    public function get_pengembalian_bulanan($bulan = 6)
    {
        $sql = "SELECT 
                    DATE_FORMAT(TANGGAL_DIKEMBALIKAN, '%b %Y') AS BULAN,
                    COUNT(*) AS TOTAL
                FROM PENGEMBALIAN
                WHERE TANGGAL_DIKEMBALIKAN >= DATE_SUB(CURDATE(), INTERVAL " . (int)$bulan . " MONTH)
                GROUP BY DATE_FORMAT(TANGGAL_DIKEMBALIKAN, '%Y-%m')
                ORDER BY DATE_FORMAT(TANGGAL_DIKEMBALIKAN, '%Y-%m') ASC";
        
        return $this->db->query($sql)->result();
    }

    // ==================== GRAFIK: STATUS PEMINJAMAN ====================

    public function get_status_peminjaman()
    {
        $result = $this->db->select('STATUS_PEMINJAMAN, COUNT(*) AS TOTAL')
            ->from('PEMINJAMAN')
            ->group_by('STATUS_PEMINJAMAN')
            ->get()
            ->result();
        
        $status = ['Dipinjam' => 0, 'Dikembalikan' => 0];
        foreach ($result as $row) {
            $status[$row->STATUS_PEMINJAMAN] = (int) $row->TOTAL;
        }
        return $status;
    }

    // ==================== GRAFIK: TOP BARANG DIPINJAM ====================

    public function get_top_barang_dipinjam($limit = 10)
    {
        return $this->db->select('b.NAMA_BARANG, COUNT(dp.BARANG_ID) AS TOTAL_PINJAM')
            ->from('DETAIL_PEMINJAMAN dp')
            ->join('BARANG b', 'b.BARANG_ID = dp.BARANG_ID')
            ->group_by('b.BARANG_ID, b.NAMA_BARANG')
            ->order_by('TOTAL_PINJAM', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    // ==================== GRAFIK: BARANG PER KATEGORI ====================

    public function get_barang_per_kategori()
    {
        return $this->db->select('k.NAMA_KATEGORI, COUNT(b.BARANG_ID) AS TOTAL')
            ->from('BARANG b')
            ->join('KATEGORI k', 'k.KATEGORI_ID = b.KATEGORI_ID', 'left')
            ->group_by('k.KATEGORI_ID, k.NAMA_KATEGORI')
            ->order_by('TOTAL', 'DESC')
            ->get()
            ->result();
    }

    // ==================== GRAFIK: BARANG PER KONDISI ====================

    public function get_barang_per_kondisi()
    {
        return $this->db->select('ko.NAMA_KONDISI, COUNT(b.BARANG_ID) AS TOTAL')
            ->from('BARANG b')
            ->join('KONDISI ko', 'ko.KONDISI_ID = b.KONDISI_ID', 'left')
            ->group_by('ko.KONDISI_ID, ko.NAMA_KONDISI')
            ->order_by('TOTAL', 'DESC')
            ->get()
            ->result();
    }

    // ==================== GRAFIK: BARANG PER LOKASI ====================

    public function get_barang_per_lokasi()
    {
        return $this->db->select('l.NAMA_LOKASI, COUNT(b.BARANG_ID) AS TOTAL')
            ->from('BARANG b')
            ->join('LOKASI l', 'l.LOKASI_ID = b.LOKASI_ID', 'left')
            ->group_by('l.LOKASI_ID, l.NAMA_LOKASI')
            ->order_by('TOTAL', 'DESC')
            ->get()
            ->result();
    }
}
