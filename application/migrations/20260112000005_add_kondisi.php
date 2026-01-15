<?php
class Migration_Add_kondisi extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'KONDISI_ID'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'NAMA_KONDISI' => ['type' => 'VARCHAR', 'constraint' => '128'],
            'KETERANGAN'   => ['type' => 'TEXT', 'null' => TRUE],
        ]);
        $this->dbforge->add_key('KONDISI_ID', TRUE);
        $this->dbforge->create_table('KONDISI');
    }
    public function down() { $this->dbforge->drop_table('KONDISI'); }
}