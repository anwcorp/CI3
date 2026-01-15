<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    private $user_data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model');
        $this->load->model('Peminjaman_model');
        $this->load->model('Pengembalian_model');
        $this->load->library('form_validation');

        // Fix Auth & User Data
        is_logged_in(); 
        $role = get_role_name();
        if (!in_array($role, ['Administrator', 'Admin', 'Kepala Bagian'])) {
            redirect('dashboard'); 
        }

        $user_id = get_user_id();
        $db_user = $this->db->get_where('USERS', ['USER_ID' => $user_id])->row_array();

        $this->user_data = [
            'name'  => isset($db_user['NAMA']) ? $db_user['NAMA'] : 'User',
            'image' => 'default.jpg',
            'role_id' => isset($db_user['ROLE_ID']) ? $db_user['ROLE_ID'] : 0
        ];
    }

    private function _render($view, $data) {
        $data['user'] = $this->user_data;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view($view, $data);
        $this->load->view('templates/footer');
    }

    public function index()
    {
        $data['title'] = 'Laporan Sistem Inventaris';
        $this->_render('laporan/index', $data);
    }

    public function barang()
    {
        $data['title'] = 'Laporan Data Barang';
        $data['barang'] = $this->Barang_model->get_all_with_relations();
        $this->_render('laporan/barang', $data);
    }

    public function peminjaman()
    {
        $this->form_validation->set_rules('tanggal_dari', 'Tanggal Dari', 'required');
        $this->form_validation->set_rules('tanggal_sampai', 'Tanggal Sampai', 'required');

        $data['title'] = 'Laporan Peminjaman';
        
        if ($this->form_validation->run() == FALSE) {
            $data['peminjaman'] = array();
        } else {
            $dari = $this->input->post('tanggal_dari', TRUE);
            $sampai = $this->input->post('tanggal_sampai', TRUE);
            $data['tanggal_dari'] = $dari;
            $data['tanggal_sampai'] = $sampai;
            $data['peminjaman'] = $this->get_peminjaman_by_periode($dari, $sampai);
        }
        $this->_render('laporan/peminjaman', $data);
    }

    public function pengembalian()
    {
        $this->form_validation->set_rules('tanggal_dari', 'Tanggal Dari', 'required');
        $this->form_validation->set_rules('tanggal_sampai', 'Tanggal Sampai', 'required');

        $data['title'] = 'Laporan Pengembalian';

        if ($this->form_validation->run() == FALSE) {
            $data['pengembalian'] = array();
        } else {
            $dari = $this->input->post('tanggal_dari', TRUE);
            $sampai = $this->input->post('tanggal_sampai', TRUE);
            $data['tanggal_dari'] = $dari;
            $data['tanggal_sampai'] = $sampai;
            $data['pengembalian'] = $this->get_pengembalian_by_periode($dari, $sampai);
        }
        $this->_render('laporan/pengembalian', $data);
    }

    // --- FIX QUERY UNTUK MYSQL ---
    private function get_peminjaman_by_periode($dari, $sampai)
    {
        $sql = "SELECT 
                    p.PEMINJAMAN_ID,
                    u.NAMA AS NAMA_PEMINJAM,
                    DATE_FORMAT(p.TANGGAL_PINJAM, '%d-%m-%Y') AS TANGGAL_PINJAM,
                    DATE_FORMAT(p.TANGGAL_KEMBALI, '%d-%m-%Y') AS TANGGAL_KEMBALI,
                    p.STATUS_PEMINJAMAN
                FROM PEMINJAMAN p
                INNER JOIN USERS u ON p.USER_ID = u.USER_ID
                WHERE p.TANGGAL_PINJAM BETWEEN ? AND ?
                ORDER BY p.PEMINJAMAN_ID DESC";

        return $this->db->query($sql, array($dari, $sampai))->result();
    }

    private function get_pengembalian_by_periode($dari, $sampai)
    {
        $sql = "SELECT 
                    pg.PENGEMBALIAN_ID,
                    u.NAMA AS NAMA_PEMINJAM,
                    DATE_FORMAT(pg.TANGGAL_DIKEMBALIKAN, '%d-%m-%Y') AS TANGGAL_DIKEMBALIKAN,
                    pg.CATATAN
                FROM PENGEMBALIAN pg
                INNER JOIN PEMINJAMAN pm ON pg.PEMINJAMAN_ID = pm.PEMINJAMAN_ID
                INNER JOIN USERS u ON pm.USER_ID = u.USER_ID
                WHERE pg.TANGGAL_DIKEMBALIKAN BETWEEN ? AND ?
                ORDER BY pg.PENGEMBALIAN_ID DESC";

        return $this->db->query($sql, array($dari, $sampai))->result();
    }

    public function kirim_email_peminjaman(){

        $email_tujuan = $this->input->post('email_tujuan');
        
        // 1. Ambil data laporan (sesuaikan dengan logic filter di model lu)
        // Gua asumsikan lu ambil semua data peminjaman buat rekap
        $this->load->model('Peminjaman_model');
        $data_laporan = $this->Peminjaman_model->get_all_with_relations();

        // 2. Load Library Email
        $this->load->library('email');

        // 3. Susun isi email (Gua bikin pake format tabel HTML biar rapi)
        $message = "<h2>Laporan Peminjaman Barang</h2>";
        $message .= "<p>Berikut adalah rekap data peminjaman per tanggal: " . date('d-m-Y H:i') . "</p>";
        $message .= "<table border='1' cellpadding='5' style='border-collapse: collapse; width: 100%;'>";
        $message .= "<tr style='background: #eee;'>
                        <th>ID</th>
                        <th>Peminjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                    </tr>";

        foreach ($data_laporan as $l) {
            $message .= "<tr>
                            <td>{$l->PEMINJAMAN_ID}</td>
                            <td>{$l->NAMA_PEMINJAM}</td>
                            <td>{$l->TANGGAL_PINJAM}</td>
                            <td>{$l->TANGGAL_KEMBALI}</td>
                            <td>{$l->STATUS_PEMINJAMAN}</td>
                        </tr>";
        }
        $message .= "</table>";
        $message .= "<p>Email ini dikirim otomatis oleh Sistem Inventaris.</p>";

        // 4. Konfigurasi Kirim
        $this->email->from('admin-inventaris@domain.com', 'Sistem Inventaris.');
        $this->email->to($email_tujuan);
        $this->email->subject('Laporan Peminjaman Barang - ' . date('d/m/Y'));
        $this->email->message($message);

        if ($this->email->send()) {
            $this->session->set_flashdata('success', 'Laporan berhasil dikirim ke ' . $email_tujuan);
        } else {
            // Debugging kalo gagal
            log_message('error', $this->email->print_debugger());
            $this->session->set_flashdata('error', 'Gagal mengirim email. Cek log sistem!');
        }

        redirect('laporan/peminjaman');
    }

    public function export_pdf_peminjaman()
{
    $dari = $this->input->get('dari');
    $sampai = $this->input->get('sampai');

    $this->load->model('Peminjaman_model');
    // Jika model lu belum punya filter, pake get_all dulu buat ngetes
    $data['peminjaman'] = $this->Peminjaman_model->get_all_with_relations(); 
    $data['periode'] = $dari . ' s/d ' . $sampai;

    $html = $this->load->view('laporan/pdf_template', $data, true);

    // Eksekusi Dompdf
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    // Output ke browser
    $dompdf->stream("Laporan_Peminjaman_" . date('Ymd') . ".pdf", ["Attachment" => 1]);
}

public function export_excel_peminjaman()
{
    $this->load->model('Peminjaman_model');
    $peminjaman = $this->Peminjaman_model->get_all_with_relations();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Kolom Header
    $sheet->setCellValue('A1', 'No')
          ->setCellValue('B1', 'ID Peminjaman')
          ->setCellValue('C1', 'Nama Peminjam')
          ->setCellValue('D1', 'Tanggal Pinjam')
          ->setCellValue('E1', 'Status');

    $row = 2; $no = 1;
    foreach ($peminjaman as $p) {
        $sheet->setCellValue('A' . $row, $no++)
              ->setCellValue('B' . $row, '#' . $p->PEMINJAMAN_ID)
              ->setCellValue('C' . $row, $p->NAMA_PEMINJAM)
              ->setCellValue('D' . $row, $p->TANGGAL_PINJAM)
              ->setCellValue('E' . $row, $p->STATUS_PEMINJAMAN);
        $row++;
    }

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan_Peminjaman.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
}

// --- EXPORT PDF PENGEMBALIAN ---
public function export_pdf_pengembalian()
{
    $dari = $this->input->get('dari');
    $sampai = $this->input->get('sampai');

    $data['pengembalian'] = $this->get_pengembalian_by_periode($dari, $sampai);
    $data['periode'] = $dari . ' s/d ' . $sampai;

    // Pakai template PDF khusus pengembalian
    $html = $this->load->view('laporan/pdf_pengembalian_template', $data, true);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("Laporan_Pengembalian_" . $dari . ".pdf", ["Attachment" => 1]);
}

// --- EXPORT EXCEL PENGEMBALIAN ---
public function export_excel_pengembalian()
{
    $dari = $this->input->get('dari');
    $sampai = $this->input->get('sampai');
    $pengembalian = $this->get_pengembalian_by_periode($dari, $sampai);

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header Kolom
    $sheet->setCellValue('A1', 'No')
          ->setCellValue('B1', 'ID Pengembalian')
          ->setCellValue('C1', 'Nama Peminjam')
          ->setCellValue('D1', 'Tanggal Kembali')
          ->setCellValue('E1', 'Catatan');

    $row = 2; $no = 1;
    foreach ($pengembalian as $p) {
        $sheet->setCellValue('A' . $row, $no++)
              ->setCellValue('B' . $row, '#' . $p->PENGEMBALIAN_ID)
              ->setCellValue('C' . $row, $p->NAMA_PEMINJAM)
              ->setCellValue('D' . $row, $p->TANGGAL_DIKEMBALIKAN)
              ->setCellValue('E' . $row, $p->CATATAN);
        $row++;
    }

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan_Pengembalian.xlsx"');
    $writer->save('php://output');
}

// --- KIRIM EMAIL PENGEMBALIAN ---
public function kirim_email_pengembalian() {
    $email_tujuan = $this->input->post('email_tujuan');
    $dari = $this->input->post('tgl_dari');
    $sampai = $this->input->post('tgl_sampai');
    $data_laporan = $this->get_pengembalian_by_periode($dari, $sampai);
    
    $this->load->library('email');

    // Susun message dengan style table yang konsisten
    $message = "<h2>Rekap Pengembalian Barang</h2>";
    $message .= "<p>Berikut adalah rekap data pengembalian periode: <b>$dari</b> s/d <b>$sampai</b></p>";
    $message .= "<table border='1' cellpadding='8' style='border-collapse: collapse; width: 100%; font-family: sans-serif;'>";
    $message .= "<tr style='background-color: #f2f2f2;'>
                    <th width='10%'>ID</th>
                    <th width='30%'>Nama Peminjam</th>
                    <th width='25%'>Tgl Dikembalikan</th>
                    <th width='35%'>Catatan</th>
                </tr>";

    if (!empty($data_laporan)) {
        foreach ($data_laporan as $l) {
            $message .= "<tr>
                            <td align='center'>#{$l->PENGEMBALIAN_ID}</td>
                            <td>{$l->NAMA_PEMINJAM}</td>
                            <td align='center'>{$l->TANGGAL_DIKEMBALIKAN}</td>
                            <td>" . ($l->CATATAN ? $l->CATATAN : '-') . "</td>
                         </tr>";
        }
    } else {
        $message .= "<tr><td colspan='4' align='center'>Tidak ada data pada periode ini.</td></tr>";
    }
    
    $message .= "</table>";
    $message .= "<p style='font-size: 11px; color: #777;'>Email ini dikirim otomatis oleh Sistem Inventaris.</p>";

    $this->email->from('admin@inventaris.com', 'Sistem Inventaris');
    $this->email->to($email_tujuan);
    $this->email->subject('Laporan Pengembalian Periode ' . $dari . ' s/d ' . $sampai);
    $this->email->message($message);

    if ($this->email->send()) {
        $this->session->set_flashdata('success', 'Email rekap pengembalian berhasil dikirim ke ' . $email_tujuan);
    } else {
        $this->session->set_flashdata('error', 'Gagal kirim email. Cek konfigurasi SMTP lu!');
    }
    redirect('laporan/pengembalian');
}

public function export_pdf_barang() {
    $data['barang'] = $this->Barang_model->get_all_with_relations();
    $data['title'] = "LAPORAN STOK BARANG";
    
    // Pake template PDF khusus barang
    $html = $this->load->view('laporan/pdf_barang_template', $data, true);
    
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape'); // Barang kolomnya banyak, mending landscape
    $dompdf->render();
    $dompdf->stream("Laporan_Stok_Barang.pdf", ["Attachment" => 1]);
}

public function export_excel_barang() {
    $barang = $this->Barang_model->get_all_with_relations();
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header Kolom
    $sheet->setCellValue('A1', 'No')
          ->setCellValue('B1', 'KODE BARANG')
          ->setCellValue('C1', 'NAMA BARANG')
          ->setCellValue('D1', 'KATEGORI')
          ->setCellValue('E1', 'STOK')
          ->setCellValue('F1', 'LOKASI');

    $row = 2; $no = 1;
    foreach ($barang as $b) {
        $sheet->setCellValue('A'.$row, $no++)
              ->setCellValue('B'.$row, $b->KODE_BARANG)
              ->setCellValue('C'.$row, $b->NAMA_BARANG)
              ->setCellValue('D'.$row, $b->NAMA_KATEGORI)
              ->setCellValue('E'.$row, $b->JUMLAH)
              ->setCellValue('F'.$row, $b->NAMA_LOKASI);
        $row++;
    }

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan_Data_Barang.xlsx"');
    $writer->save('php://output');
}

public function kirim_email_barang() {
    $email_tujuan = $this->input->post('email_tujuan');
    $data_barang = $this->Barang_model->get_all_with_relations();
    
    $this->load->library('email');

    $message = "<h2>Rekap Laporan Stok Barang</h2>";
    $message .= "<p>Dicetak pada: " . date('d-m-Y H:i') . "</p>";
    $message .= "<table border='1' cellpadding='8' style='border-collapse: collapse; width: 100%; font-family: sans-serif;'>";
    $message .= "<tr style='background-color: #f2f2f2;'>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Lokasi</th>
                </tr>";

    foreach ($data_barang as $b) {
        $message .= "<tr>
                        <td align='center'>{$b->KODE_BARANG}</td>
                        <td>{$b->NAMA_BARANG}</td>
                        <td>{$b->NAMA_KATEGORI}</td>
                        <td align='center'>{$b->JUMLAH}</td>
                        <td>{$b->NAMA_LOKASI}</td>
                     </tr>";
    }
    $message .= "</table>";
    
    $this->email->from('admin@inventaris.com', 'Sistem Inventaris');
    $this->email->to($email_tujuan);
    $this->email->subject('Laporan Stok Barang - ' . date('d/m/Y'));
    $this->email->message($message);

    if ($this->email->send()) {
        $this->session->set_flashdata('success', 'Email stok barang berhasil dikirim!');
    } else {
        $this->session->set_flashdata('error', 'Gagal kirim email.');
    }
    redirect('laporan/barang');
}

}