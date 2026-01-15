<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Base_model extends CI_Model
{
    protected $db_type;

    public function __construct()
    {
        parent::__construct();
        $this->db_type = $this->db->dbdriver;
    }

    protected function is_oracle()
    {
        return $this->db_type === 'oci8';
    }

    protected function is_mysql()
    {
        return $this->db_type === 'mysqli';
    }
}
