<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Supplier extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'kode_supplier' => [
        'type' => 'VARCHAR',
        'constraint' => 5,
        'null' => false,
      ],
      'nama_supplier' => [
        'type' => 'VARCHAR',
        'constraint' => 35,
        'null' => false,
      ],
      'alamat_supplier' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => false,
      ],
      'telp_supplier' => [
        'type' => 'VARCHAR',
        'constraint' => 25,
        'null' => false,
      ],
      'kota_supplier' => [
        'type' => 'VARCHAR',
        'constraint' => 20,
        'null' => false,
      ],
      'created_at' => [
        'type' => 'DATETIME',
        'null' => false,
      ],
      'updated_at' => [
        'type' => 'DATETIME',
        'null' => false,
      ],
    ]);
    $this->forge->addKey('kode_supplier', true);
    $this->forge->createTable('supplier');
  }

  public function down()
  {
    $this->forge->dropTable('supplier');
  }
}
