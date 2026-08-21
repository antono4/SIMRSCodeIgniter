<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePoliDokterTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode'       => ['type' => 'VARCHAR', 'constraint' => 10, 'unique' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'keterangan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('poli');

        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode_dokter'      => ['type' => 'VARCHAR', 'constraint' => 10, 'unique' => true],
            'nama'             => ['type' => 'VARCHAR', 'constraint' => 100],
            'spesialisasi'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'poli_id'          => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'telepon'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'jadwal'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tarif_konsultasi' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'is_active'        => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('poli_id', 'poli', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('dokter');
    }

    public function down()
    {
        $this->forge->dropTable('dokter');
        $this->forge->dropTable('poli');
    }
}
