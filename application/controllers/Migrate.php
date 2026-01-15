<?php
class Migrate extends CI_Controller {
    public function index() {
        $this->load->library('migration');

        // CEK APAKAH FOLDER & FILE TERDETEKSI
        $path = $this->config->item('migration_path');
        $files = glob($path . '*.php');
        
        echo "<h4>Hasil Investigasi:</h4>";
        echo "Path Folder: <b>" . $path . "</b><br>";
        echo "File ditemukan: <b>" . count($files) . " file</b><br>";
        
        if(count($files) > 0) {
            echo "Daftar file: <pre>";
            print_r($files);
            echo "</pre>";
        }

        // EKSEKUSI
        if ($this->migration->latest() === FALSE) {
            echo "<h3 style='color:red'>GAGAL:</h3>";
            show_error($this->migration->error_string());
        } else {
            echo "<h3 style='color:green'>GOKIL! MIGRATION SUKSES!</h3>";
            // Cek status di database
            $status = $this->db->get('migrations')->row();
            echo "Versi saat ini di Database: <b>" . $status->version . "</b>";
        }
    }
}