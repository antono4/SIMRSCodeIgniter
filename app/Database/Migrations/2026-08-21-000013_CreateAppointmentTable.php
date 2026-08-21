<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppointmentTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode'           => ['type' => 'VARCHAR', 'constraint' => 15, 'unique' => true],
            'pasien_id'      => ['type' => 'INT', 'unsigned' => true],
            'dokter_id'      => ['type' => 'INT', 'unsigned' => true],
            'tanggal'        => ['type' => 'DATE'],
            'jam'            => ['type' => 'TIME'],
            'keluhan'        => ['type' => 'TEXT', 'null' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['booking', 'dikonfirmasi', 'datang', 'selesai', 'batal'], 'default' => 'booking'],
            'pendaftaran_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['dokter_id', 'tanggal']);
        $this->forge->addForeignKey('pasien_id', 'pasien', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dokter_id', 'dokter', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pendaftaran_id', 'pendaftaran', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('appointment');
    }

    public function down()
    {
        $this->forge->dropTable('appointment');
    }
}
