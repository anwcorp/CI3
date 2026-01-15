<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function get_user_by_email($email)
    {
        // MySQL case-insensitive secara default untuk string comparison, 
        // tapi LOWER() tetap aman dipakai.
        $sql = "SELECT u.USER_ID, u.NAMA, u.EMAIL, u.PASSWORD, u.ROLE_ID, u.STATUS_USER, r.NAMA_ROLE
                FROM USERS u
                INNER JOIN ROLE r ON u.ROLE_ID = r.ROLE_ID
                WHERE LOWER(u.EMAIL) = LOWER(?)";

        $query = $this->db->query($sql, array($email));
        return $query->row();
    }

    public function register_user($data)
    {
        // FIX: Hapus USER_SEQ.NEXTVAL dan ganti SYSTIMESTAMP dengan NOW()
        $sql = "INSERT INTO USERS (NAMA, EMAIL, PASSWORD, ROLE_ID, STATUS_USER, CREATED_AT)
                VALUES (?, ?, ?, ?, 'Aktif', NOW())";

        return $this->db->query($sql, array(
            $data['nama'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['role_id']
        ));
    }
}