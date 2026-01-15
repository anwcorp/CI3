<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = [
    'protocol'    => 'smtp',
    'smtp_host'   => 'ssl://smtp.googlemail.com',
    'smtp_user'   => 'youremail@gmail.com', 
    'smtp_pass'   => 'xxxxxxxxxxxxxxxx',      // 16 digit App Password Gmail
    'smtp_port'   => 465,
    'mailtype'    => 'html',
    'charset'     => 'utf-8',
    'newline'     => "\r\n",
    'wordwrap'    => TRUE
];