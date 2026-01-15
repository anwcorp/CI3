<?php
class Migration_Add_pengembalian extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'PENGEMBALIAN_ID'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'PEMINJAMAN_ID'        => ['type' => 'INT', 'constraint' => 11],
            'TANGGAL_DIKEMBALIKAN' => ['type' => 'DATE'],
            'CATATAN'              => ['type' => 'TEXT', 'null' => TRUE],
        ]);
        $this->dbforge->add_key('PENGEMBALIAN_ID', TRUE);
        $this->dbforge->create_table('PENGEMBALIAN');
    }
    public function down() { $this->dbforge->drop_table('PENGEMBALIAN'); }
}