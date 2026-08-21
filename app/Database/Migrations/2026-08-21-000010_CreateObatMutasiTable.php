<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateObatMutasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'obat_id'      => ['type' => 'INT', 'unsigned' => true],
            'tanggal'      => ['type' => 'DATETIME', 'null' => true],
            'tipe'         => ['type' => 'ENUM', 'constraint' => ['masuk', 'keluar', 'opname'], 'null' => false],
            'jumlah'       => ['type' => 'INT', 'null' => false],
            'stok_sebelum' => ['type' => 'INT', 'default' => 0],
            'stok_sesudah' => ['type' => 'INT', 'default' => 0],
            'referensi'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'keterangan'   => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'user_id'      => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['obat_id', 'tanggal']);
        $this->forge->addForeignKey('obat_id', 'obat', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('obat_mutasi');
    }

    public function down()
    {
        $this->forge->dropTable('obat_mutasi');
    }
}
