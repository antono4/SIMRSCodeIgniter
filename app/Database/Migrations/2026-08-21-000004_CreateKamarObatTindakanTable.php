<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKamarObatTindakanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode'          => ['type' => 'VARCHAR', 'constraint' => 10, 'unique' => true],
            'nama'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'kelas'         => ['type' => 'ENUM', 'constraint' => ['VIP', 'I', 'II', 'III'], 'default' => 'III'],
            'tarif_per_hari' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'kapasitas'     => ['type' => 'INT', 'default' => 1],
            'terisi'        => ['type' => 'INT', 'default' => 0],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kamar');

        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode'       => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'kategori'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'satuan'     => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'tablet'],
            'harga_beli' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'harga_jual' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'stok'       => ['type' => 'INT', 'default' => 0],
            'expired'    => ['type' => 'DATE', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('obat');

        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode'       => ['type' => 'VARCHAR', 'constraint' => 10, 'unique' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'tarif'      => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tindakan');
    }

    public function down()
    {
        $this->forge->dropTable('tindakan');
        $this->forge->dropTable('obat');
        $this->forge->dropTable('kamar');
    }
}
