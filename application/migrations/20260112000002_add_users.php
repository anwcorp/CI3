<?php
class Migration_Add_users extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'USER_ID'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'NAMA'         => ['type' => 'VARCHAR', 'constraint' => '128'],
            'EMAIL'        => ['type' => 'VARCHAR', 'constraint' => '128'],
            'PASSWORD'     => ['type' => 'VARCHAR', 'constraint' => '256'],
            'ROLE_ID'      => ['type' => 'INT', 'constraint' => 11],
            'STATUS_USER'  => ['type' => 'VARCHAR', 'constraint' => '20', 'default' => 'Aktif'],
            'CREATED_AT'   => ['type' => 'DATETIME', 'null' => TRUE],
            'IMAGE'        => ['type' => 'VARCHAR', 'constraint' => '128', 'default' => 'default.jpg'],
        ]);
        $this->dbforge->add_key('USER_ID', TRUE);
        $this->dbforge->create_table('USERS');
    }
    public function down() { $this->dbforge->drop_table('USERS'); }
}