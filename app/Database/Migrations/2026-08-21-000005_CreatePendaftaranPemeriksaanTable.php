<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePendaftaranPemeriksaanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'no_registrasi'   => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'pasien_id'       => ['type' => 'INT', 'unsigned' => true],
            'poli_id'         => ['type' => 'INT', 'unsigned' => true],
            'dokter_id'       => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'tanggal'         => ['type' => 'DATE'],
            'jenis_kunjungan' => ['type' => 'ENUM', 'constraint' => ['rawat_jalan', 'rawat_inap', 'igd'], 'default' => 'rawat_jalan'],
            'keluhan'         => ['type' => 'TEXT', 'null' => true],
            'status'          => ['type' => 'ENUM', 'constraint' => ['menunggu', 'diperiksa', 'selesai', 'batal'], 'default' => 'menunggu'],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('tanggal');
        $this->forge->addForeignKey('pasien_id', 'pasien', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('poli_id', 'poli', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dokter_id', 'dokter', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('pendaftaran');

        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'pendaftaran_id' => ['type' => 'INT', 'unsigned' => true],
            'tanggal'        => ['type' => 'DATETIME', 'null' => true],
            'anamnesis'      => ['type' => 'TEXT', 'null' => true],
            'tekanan_darah'  => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'suhu'           => ['type' => 'DECIMAL', 'constraint' => '4,1', 'null' => true],
            'berat_badan'    => ['type' => 'DECIMAL', 'constraint' => '5,1', 'null' => true],
            'tinggi_badan'   => ['type' => 'DECIMAL', 'constraint' => '5,1', 'null' => true],
            'diagnosa'       => ['type' => 'TEXT', 'null' => true],
            'tindakan_id'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'catatan'        => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pendaftaran_id', 'pendaftaran', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tindakan_id', 'tindakan', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('pemeriksaan');
    }

    public function down()
    {
        $this->forge->dropTable('pemeriksaan');
        $this->forge->dropTable('pendaftaran');
    }
}
