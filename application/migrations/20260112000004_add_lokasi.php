<?php
class Migration_Add_lokasi extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'LOKASI_ID'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'NAMA_LOKASI' => ['type' => 'VARCHAR', 'constraint' => '128'],
            'LANTAI'      => ['type' => 'INT', 'constraint' => 11],
            'KETERANGAN'  => ['type' => 'TEXT', 'null' => TRUE],
        ]);
        $this->dbforge->add_key('LOKASI_ID', TRUE);
        $this->dbforge->create_table('LOKASI');
    }
    public function down() { $this->dbforge->drop_table('LOKASI'); }
}