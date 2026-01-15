<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seeder extends CI_Controller
{
    public function index()
    {
        // 0. Matikan Foreign Key biar pas truncate gak error
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');

        echo "<h3>--- Memulai Proses Seeding (Sinkron Model & Migration) ---</h3>";

        // 1. Seed Tabel ROLE (Kolom: NAMA_ROLE)
        $this->db->truncate('ROLE');
        $roles = [
            ['NAMA_ROLE' => 'Administrator'],
            ['NAMA_ROLE' => 'Admin'],
            ['NAMA_ROLE' => 'Kepala Bagian'],
            ['NAMA_ROLE' => 'Pegawai']
        ];
        $this->db->insert_batch('ROLE', $roles);
        echo "✅ ROLE (NAMA_ROLE) berhasil disuntik.<br>";

        // 2. Seed Tabel KONDISI (Nama tabel & kolom BESAR)
        $this->db->truncate('KONDISI');
        $kondisi = [
            ['NAMA_KONDISI' => 'Baik', 'KETERANGAN' => 'Barang berfungsi normal'],
            ['NAMA_KONDISI' => 'Rusak Ringan', 'KETERANGAN' => 'Lecet pemakaian / butuh servis kecil'],
            ['NAMA_KONDISI' => 'Rusak Berat', 'KETERANGAN' => 'Tidak bisa digunakan']
        ];
        $this->db->insert_batch('KONDISI', $kondisi);
        echo "✅ KONDISI berhasil disuntik.<br>";

        // 3. Seed Tabel KATEGORI
        $this->db->truncate('KATEGORI');
        $kategori = [
            ['NAMA_KATEGORI' => 'Elektronik', 'KETERANGAN' => 'Laptop, PC, Monitor, dll'],
            ['NAMA_KATEGORI' => 'Furniture', 'KETERANGAN' => 'Meja, Kursi, Lemari'],
            ['NAMA_KATEGORI' => 'Alat Tulis Kantor', 'KETERANGAN' => 'Printer, Scanner, ATK']
        ];
        $this->db->insert_batch('KATEGORI', $kategori);
        echo "✅ KATEGORI berhasil disuntik.<br>";

        // 4. Seed Tabel LOKASI
        $this->db->truncate('LOKASI');
        $lokasi = [
            ['NAMA_LOKASI' => 'Gudang Utama', 'LANTAI' => 1, 'KETERANGAN' => 'Penyimpanan pusat'],
            ['NAMA_LOKASI' => 'Ruang IT', 'LANTAI' => 2, 'KETERANGAN' => 'Divisi Teknologi'],
            ['NAMA_LOKASI' => 'Ruang Rapat', 'LANTAI' => 2, 'KETERANGAN' => 'Area publik kantor']
        ];
        $this->db->insert_batch('LOKASI', $lokasi);
        echo "✅ LOKASI berhasil disuntik.<br>";

        // 5. Seed Akun Admin (Sinkron dengan Auth_model & USERS Migration)
        $this->db->truncate('USERS');
        $admin = [
            'NAMA'         => 'Super Admin',
            'EMAIL'        => 'admin@gmail.com',
            'PASSWORD'     => password_hash('admin123', PASSWORD_DEFAULT),
            'ROLE_ID'      => 1, // Administrator
            'STATUS_USER'  => 'Aktif', // Bukan IS_ACTIVE
            'CREATED_AT'   => date('Y-m-d H:i:s'), // Bukan time() karena Model minta DATETIME
            'IMAGE'        => 'default.jpg'
        ];
        $this->db->insert('USERS', $admin);
        echo "✅ Akun Admin (USERS) berhasil disuntik.<br>";

        // 6. Nyalakan lagi Foreign Key
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        echo "<h2>🚀 SEMUA DATA SINKRON, BANG! BURUAN LOGIN!</h2>";
        echo "Email: admin@gmail.com | Pass: admin123";
    }
}