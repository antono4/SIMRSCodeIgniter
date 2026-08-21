<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengaturanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            '`key`'       => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            '`value`'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengaturan');

        $defaults = [
            ['key' => 'nama_rs',        'value' => 'RS SIMRS'],
            ['key' => 'alamat_rs',      'value' => 'Jl. Kesehatan No. 1, Jakarta'],
            ['key' => 'telepon_rs',     'value' => '(021) 123-4567'],
            ['key' => 'logo_rs',        'value' => 'hospital'],
            ['key' => 'tagline',        'value' => 'Sistem Informasi Manajemen Rumah Sakit'],
            ['key' => 'tampilkan_logo', 'value' => 'ico'],
            ['key' => 'updated_at',     'value' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('pengaturan')->insertBatch($defaults);
    }

    public function down()
    {
        $this->forge->dropTable('pengaturan');
    }
}
