<?php
class Migration_Add_detail_peminjaman extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'DETAIL_PEMINJAMAN_ID' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'PEMINJAMAN_ID'        => ['type' => 'INT', 'constraint' => 11],
            'BARANG_ID'            => ['type' => 'INT', 'constraint' => 11],
            'JUMLAH_PINJAM'        => ['type' => 'INT', 'constraint' => 11],
        ]);
        $this->dbforge->add_key('DETAIL_PEMINJAMAN_ID', TRUE);
        $this->dbforge->create_table('DETAIL_PEMINJAMAN');
    }
    public function down() { $this->dbforge->drop_table('DETAIL_PEMINJAMAN'); }
}