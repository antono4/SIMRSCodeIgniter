<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTagihanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'no_invoice'      => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'pendaftaran_id'  => ['type' => 'INT', 'unsigned' => true],
            'tanggal'         => ['type' => 'DATETIME', 'null' => true],
            'total'           => ['type' => 'DECIMAL', 'constraint' => '14,2', 'default' => 0],
            'status'          => ['type' => 'ENUM', 'constraint' => ['belum_bayar', 'lunas'], 'default' => 'belum_bayar'],
            'metode_bayar'    => ['type' => 'ENUM', 'constraint' => ['tunai', 'transfer', 'bpjs'], 'null' => true],
            'kasir_id'        => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'paid_at'         => ['type' => 'DATETIME', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pendaftaran_id', 'pendaftaran', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kasir_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('tagihan');

        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tagihan_id' => ['type' => 'INT', 'unsigned' => true],
            'deskripsi'  => ['type' => 'VARCHAR', 'constraint' => 200],
            'qty'        => ['type' => 'INT', 'default' => 1],
            'harga'      => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'subtotal'   => ['type' => 'DECIMAL', 'constraint' => '14,2', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('tagihan_id', 'tagihan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tagihan_detail');
    }

    public function down()
    {
        $this->forge->dropTable('tagihan_detail');
        $this->forge->dropTable('tagihan');
    }
}
