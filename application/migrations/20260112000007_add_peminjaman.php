<?php
class Migration_Add_peminjaman extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'PEMINJAMAN_ID'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'USER_ID'           => ['type' => 'INT', 'constraint' => 11],
            'TANGGAL_PINJAM'    => ['type' => 'DATE'],
            'TANGGAL_KEMBALI'   => ['type' => 'DATE'],
            'STATUS_PEMINJAMAN' => ['type' => 'VARCHAR', 'constraint' => '50'],
        ]);
        $this->dbforge->add_key('PEMINJAMAN_ID', TRUE);
        $this->dbforge->create_table('PEMINJAMAN');
    }
    public function down() { $this->dbforge->drop_table('PEMINJAMAN'); }
}