<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAntrianToPendaftaranTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pendaftaran', [
            'no_antrian' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'null'       => true,
                'after'      => 'no_registrasi',
            ],
            'status_antrian' => [
                'type'       => 'ENUM',
                'constraint' => ['menunggu', 'dipanggil', 'dilayani', 'selesai', 'dilewati'],
                'default'    => 'menunggu',
                'after'      => 'status',
            ],
            'waktu_panggil' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'status_antrian',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pendaftaran', ['no_antrian', 'status_antrian', 'waktu_panggil']);
    }
}
