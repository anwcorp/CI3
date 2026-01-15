<?php
class Migration_Add_barang extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'BARANG_ID'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'KODE_BARANG'       => ['type' => 'VARCHAR', 'constraint' => '50'],
            'NAMA_BARANG'       => ['type' => 'VARCHAR', 'constraint' => '128'],
            'KATEGORI_ID'       => ['type' => 'INT', 'constraint' => 11],
            'LOKASI_ID'         => ['type' => 'INT', 'constraint' => 11],
            'KONDISI_ID'        => ['type' => 'INT', 'constraint' => 11],
            'JUMLAH'            => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'TANGGAL_PEROLEHAN' => ['type' => 'DATE'],
            'STATUS_BARANG'     => ['type' => 'VARCHAR', 'constraint' => '50', 'default' => 'Tersedia'],
        ]);
        $this->dbforge->add_key('BARANG_ID', TRUE);
        $this->dbforge->create_table('BARANG');
    }
    public function down() { $this->dbforge->drop_table('BARANG'); }
}