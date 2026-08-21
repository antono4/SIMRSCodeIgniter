<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcd10Table extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'   => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode' => ['type' => 'VARCHAR', 'constraint' => 10, 'unique' => true],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 200],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('icd10');

        $this->forge->addColumn('pemeriksaan', [
            'icd10_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
                'after'    => 'diagnosa',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pemeriksaan', 'icd10_id');
        $this->forge->dropTable('icd10');
    }
}
