<?php
class Migration_Add_kategori extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'KATEGORI_ID'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'NAMA_KATEGORI' => ['type' => 'VARCHAR', 'constraint' => '128'],
            'KETERANGAN'    => ['type' => 'TEXT', 'null' => TRUE],
        ]);
        $this->dbforge->add_key('KATEGORI_ID', TRUE);
        $this->dbforge->create_table('KATEGORI');
    }
    public function down() { $this->dbforge->drop_table('KATEGORI'); }
}