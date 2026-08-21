<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePasienTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'no_rm'          => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'nik'            => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'nama'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'jenis_kelamin'  => ['type' => 'ENUM', 'constraint' => ['L', 'P']],
            'tempat_lahir'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'tanggal_lahir'  => ['type' => 'DATE', 'null' => true],
            'golongan_darah' => ['type' => 'ENUM', 'constraint' => ['A', 'B', 'AB', 'O', '-'], 'default' => '-'],
            'alamat'         => ['type' => 'TEXT', 'null' => true],
            'telepon'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'penjamin'       => ['type' => 'ENUM', 'constraint' => ['Umum', 'BPJS', 'Asuransi'], 'default' => 'Umum'],
            'no_bpjs'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pasien');
    }

    public function down()
    {
        $this->forge->dropTable('pasien');
    }
}
