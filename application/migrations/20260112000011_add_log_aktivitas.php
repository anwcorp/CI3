<?php
class Migration_Add_log_aktivitas extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'log_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'user_id'        => ['type' => 'INT', 'constraint' => 11],
            'aktivitas'      => ['type' => 'TEXT'],
            'peminjaman_id'  => ['type' => 'INT', 'constraint' => 11, 'null' => TRUE],
            'pengembalian_id'=> ['type' => 'INT', 'constraint' => 11, 'null' => TRUE],
            'barang_id'      => ['type' => 'INT', 'constraint' => 11, 'null' => TRUE],
            'waktu'          => ['type' => 'DATETIME'],
        ]);
        $this->dbforge->add_key('log_id', TRUE);
        $this->dbforge->create_table('log_aktivitas');
    }
    public function down() { $this->dbforge->drop_table('log_aktivitas'); }
}