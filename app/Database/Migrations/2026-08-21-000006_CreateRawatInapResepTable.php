<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRawatInapResepTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'pendaftaran_id'  => ['type' => 'INT', 'unsigned' => true],
            'kamar_id'        => ['type' => 'INT', 'unsigned' => true],
            'tanggal_masuk'   => ['type' => 'DATETIME'],
            'tanggal_keluar'  => ['type' => 'DATETIME', 'null' => true],
            'status'          => ['type' => 'ENUM', 'constraint' => ['dirawat', 'pulang'], 'default' => 'dirawat'],
            'catatan'         => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pendaftaran_id', 'pendaftaran', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kamar_id', 'kamar', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rawat_inap');

        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'no_resep'       => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'pemeriksaan_id' => ['type' => 'INT', 'unsigned' => true],
            'tanggal'        => ['type' => 'DATETIME', 'null' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['menunggu', 'diproses', 'selesai'], 'default' => 'menunggu'],
            'catatan'        => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pemeriksaan_id', 'pemeriksaan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('resep');

        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'resep_id'     => ['type' => 'INT', 'unsigned' => true],
            'obat_id'      => ['type' => 'INT', 'unsigned' => true],
            'jumlah'       => ['type' => 'INT', 'default' => 1],
            'aturan_pakai' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('resep_id', 'resep', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('obat_id', 'obat', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('resep_detail');
    }

    public function down()
    {
        $this->forge->dropTable('resep_detail');
        $this->forge->dropTable('resep');
        $this->forge->dropTable('rawat_inap');
    }
}
