<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLaboratoriumTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode'       => ['type' => 'VARCHAR', 'constraint' => 10, 'unique' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'satuan'     => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'nilai_normal' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'tarif'      => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('lab_jenis');

        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'no_order'       => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'pemeriksaan_id' => ['type' => 'INT', 'unsigned' => true],
            'tanggal'        => ['type' => 'DATETIME', 'null' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['diminta', 'selesai'], 'default' => 'diminta'],
            'catatan'        => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pemeriksaan_id', 'pemeriksaan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lab_order');

        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'lab_order_id' => ['type' => 'INT', 'unsigned' => true],
            'lab_jenis_id' => ['type' => 'INT', 'unsigned' => true],
            'hasil'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'keterangan'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('lab_order_id', 'lab_order', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('lab_jenis_id', 'lab_jenis', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lab_hasil');

        // Tambah role laboratorium
        $this->db->query("ALTER TABLE users MODIFY role ENUM('admin','pendaftaran','dokter','perawat','farmasi','kasir','laboratorium') NOT NULL DEFAULT 'pendaftaran'");
    }

    public function down()
    {
        $this->forge->dropTable('lab_hasil');
        $this->forge->dropTable('lab_order');
        $this->forge->dropTable('lab_jenis');
    }
}
