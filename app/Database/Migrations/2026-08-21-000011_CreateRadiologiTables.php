<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRadiologiTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode'       => ['type' => 'VARCHAR', 'constraint' => 10, 'unique' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'modalitas'  => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'tarif'      => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('rad_jenis');

        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'no_order'       => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'pemeriksaan_id' => ['type' => 'INT', 'unsigned' => true],
            'rad_jenis_id'   => ['type' => 'INT', 'unsigned' => true],
            'tanggal'        => ['type' => 'DATETIME', 'null' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['diminta', 'selesai'], 'default' => 'diminta'],
            'hasil'          => ['type' => 'TEXT', 'null' => true],
            'kesan'          => ['type' => 'TEXT', 'null' => true],
            'catatan'        => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pemeriksaan_id', 'pemeriksaan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('rad_jenis_id', 'rad_jenis', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rad_order');

        $this->db->query("ALTER TABLE users MODIFY role ENUM('admin','pendaftaran','dokter','perawat','farmasi','kasir','laboratorium','radiologi') NOT NULL DEFAULT 'pendaftaran'");
    }

    public function down()
    {
        $this->forge->dropTable('rad_order');
        $this->forge->dropTable('rad_jenis');
    }
}
