<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_model extends CI_Model
{
    private $table = 'BARANG';

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    public function get_stok_menipis($limit = 5)
    {
        $this->db->select('KODE_BARANG, NAMA_BARANG, JUMLAH');
        $this->db->from($this->table);
        $this->db->where('JUMLAH <=', 5);
        $this->db->where('JUMLAH >', 0);
        $this->db->order_by('JUMLAH', 'ASC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function get_all_with_relations()
    {
        // FIX: TO_CHAR -> DATE_FORMAT
        $sql = "SELECT 
                    b.BARANG_ID,
                    b.KODE_BARANG,
                    b.NAMA_BARANG,
                    b.JUMLAH,
                    DATE_FORMAT(b.TANGGAL_PEROLEHAN, '%d-%m-%Y') AS TANGGAL_PEROLEHAN,
                    b.STATUS_BARANG,
                    k.NAMA_KATEGORI,
                    l.NAMA_LOKASI,
                    l.LANTAI,
                    ko.NAMA_KONDISI
                FROM {$this->table} b
                INNER JOIN KATEGORI k ON b.KATEGORI_ID = k.KATEGORI_ID
                INNER JOIN LOKASI l ON b.LOKASI_ID = l.LOKASI_ID
                INNER JOIN KONDISI ko ON b.KONDISI_ID = ko.KONDISI_ID
                ORDER BY b.KODE_BARANG ASC";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_by_id($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE BARANG_ID = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row();
    }

    public function get_available_barang()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE STATUS_BARANG = 'Tersedia' AND JUMLAH > 0
                ORDER BY NAMA_BARANG ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function insert($data)
    {
        // FIX: Hapus BARANG_SEQ.NEXTVAL dan TO_DATE
        $sql = "INSERT INTO {$this->table} 
                (KODE_BARANG, NAMA_BARANG, KATEGORI_ID, LOKASI_ID, KONDISI_ID, JUMLAH, TANGGAL_PEROLEHAN, STATUS_BARANG)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        return $this->db->query($sql, array(
            $data['kode_barang'],
            $data['nama_barang'],
            $data['kategori_id'],
            $data['lokasi_id'],
            $data['kondisi_id'],
            $data['jumlah'],
            $data['tanggal_perolehan'], // MySQL otomatis baca 'YYYY-MM-DD'
            $data['status_barang']
        ));
    }

    public function generate_kode_barang($kategori_id)
    {
        $kategori = $this->db->where('KATEGORI_ID', $kategori_id)->get('KATEGORI')->row();
        if (!$kategori) return null;

        $prefix = strtoupper($kategori->NAMA_KATEGORI);

        // FIX: CAST AS UNSIGNED pengganti TO_NUMBER
        $sql = "SELECT MAX(CAST(SUBSTR(KODE_BARANG, LENGTH(?) + 1) AS UNSIGNED)) AS LAST_NUM
                FROM BARANG WHERE KODE_BARANG LIKE ?";

        $query = $this->db->query($sql, [$prefix, $prefix . '%'])->row();
        $last = $query->LAST_NUM ?? 0;
        $next = $last + 1;

        return $prefix . str_pad($next, 3, '0', STR_PAD_LEFT);
    }

    public function update($id, $data)
    {
        // FIX: Hapus TO_DATE
        $sql = "UPDATE {$this->table} 
                SET NAMA_BARANG = ?, KATEGORI_ID = ?, LOKASI_ID = ?, KONDISI_ID = ?, 
                    JUMLAH = ?, TANGGAL_PEROLEHAN = ?, STATUS_BARANG = ?
                WHERE BARANG_ID = ?";

        return $this->db->query($sql, array(
            $data['nama_barang'],
            $data['kategori_id'],
            $data['lokasi_id'],
            $data['kondisi_id'],
            $data['jumlah'],
            $data['tanggal_perolehan'],
            $data['status_barang'],
            $id
        ));
    }

    public function update_stock($barang_id, $jumlah_perubahan, $operation = 'subtract')
    {
        $operator = ($operation == 'subtract') ? '-' : '+';
        $sql = "UPDATE {$this->table} SET JUMLAH = JUMLAH $operator ? WHERE BARANG_ID = ?";
        return $this->db->query($sql, array($jumlah_perubahan, $barang_id));
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE BARANG_ID = ?";
        return $this->db->query($sql, array($id));
    }

    public function merge_duplicates()
    {
        // Logika ini aman karena pakai Query Builder, tapi saya rapikan sedikit
        $this->db->trans_start();
        $merged_count = 0;
        $total_qty = 0;

        $sql = "SELECT NAMA_BARANG, KATEGORI_ID, LOKASI_ID, MIN(BARANG_ID) as BARANG_ID_UTAMA, SUM(JUMLAH) as TOTAL_STOK
                FROM BARANG GROUP BY NAMA_BARANG, KATEGORI_ID, LOKASI_ID HAVING COUNT(*) > 1";
        
        $duplicates = $this->db->query($sql)->result();

        foreach ($duplicates as $dup) {
            $items = $this->db->where([
                'NAMA_BARANG' => $dup->NAMA_BARANG,
                'KATEGORI_ID' => $dup->KATEGORI_ID,
                'LOKASI_ID' => $dup->LOKASI_ID
            ])->get('BARANG')->result();

            if (count($items) <= 1) continue;

            $this->db->where('BARANG_ID', $dup->BARANG_ID_UTAMA)->update('BARANG', ['JUMLAH' => $dup->TOTAL_STOK]);

            foreach ($items as $item) {
                if ($item->BARANG_ID != $dup->BARANG_ID_UTAMA) {
                    $this->db->where('BARANG_ID', $item->BARANG_ID)->delete('BARANG');
                    $merged_count++;
                }
            }
            $total_qty += $dup->TOTAL_STOK;
        }
        $this->db->trans_complete();
        return ['success' => $this->db->trans_status(), 'merged' => $merged_count, 'total_qty' => $total_qty];
    }
}