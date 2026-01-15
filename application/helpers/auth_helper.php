<?php 

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('user_id')) {
        redirect('auth');
    }
}

function get_role_name()
{
    $ci = get_instance();
    $role = $ci->session->userdata('nama_role');
    return $role ? $role : ''; // Return string kosong jika null biar gak error
}

function get_user_id()
{
    $ci = get_instance();
    return $ci->session->userdata('user_id');
}

function send_borrow_notification($user_email, $user_nama, $data_barang) {
    $ci = get_instance();
    $ci->load->library('email');

    $ci->email->from('email-admin-lu@gmail.com', 'Admin Inventaris');
    $ci->email->to($user_email);
    $ci->email->subject('Konfirmasi Peminjaman Barang - ' . date('d M Y'));

    // Desain pesan email sederhana
    $message = "<h3>Halo, {$user_nama}!</h3>";
    $message .= "<p>Peminjaman barang lu udah berhasil dicatat di sistem.</p>";
    $message .= "<b>Daftar Barang:</b><br><ul>";
    
    foreach ($data_barang as $item) {
        $message .= "<li>{$item['nama_barang']} ({$item['jumlah']} unit)</li>";
    }
    
    $message .= "</ul><p>Harap kembalikan barang tepat waktu ya nyet. Thanks!</p>";

    $ci->email->message($message);
    
    return $ci->email->send();
}