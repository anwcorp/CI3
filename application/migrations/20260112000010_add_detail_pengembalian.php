<?php
class Migration_Add_detail_pengembalian extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'DETAIL_PENGEMBALIAN_ID' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'PENGEMBALIAN_ID'        => ['type' => 'INT', 'constraint' => 11],
            'BARANG_ID'              => ['type' => 'INT', 'constraint' => 11],
            'JUMLAH_KEMBALI'         => ['type' => 'INT', 'constraint' => 11],
            'KONDISI_SETELAH'        => ['type' => 'INT', 'constraint' => 11], // FK ke KONDISI_ID
        ]);
        $this->dbforge->add_key('DETAIL_PENGEMBALIAN_ID', TRUE);
        $this->dbforge->create_table('DETAIL_PENGEMBALIAN');
    }
    public function down() { $this->dbforge->drop_table('DETAIL_PENGEMBALIAN'); }
}