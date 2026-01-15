<?php
class Migration_Add_role extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'ROLE_ID'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'NAMA_ROLE' => ['type' => 'VARCHAR', 'constraint' => '128'],
        ]);
        $this->dbforge->add_key('ROLE_ID', TRUE);
        $this->dbforge->create_table('ROLE');
    }
    public function down() { $this->dbforge->drop_table('ROLE'); }
}