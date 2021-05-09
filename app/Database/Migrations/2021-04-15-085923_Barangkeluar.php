<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Keluarbarang extends Migration
{
  public function up()
  {
    // ignore the linter error
    $this->db->disableForeignKeyChecks();

    $this->forge->addField([
      'id_barang_keluar' => [
        'type'       => 'VARCHAR',
        'constraint' => 36,
        'null'       => false,
      ],
      'kode_barang' => [
        'type'       => 'VARCHAR',
        'constraint' => 36,
        'null'       => false,
      ],
      'nama_barang' => [
        'type'       => 'VARCHAR',
        'constraint' => 30,
        'null'       => false,
      ],
      'tanggal_keluar' => [
        'type' => 'DATE',
        'null' => false,
      ],
      'jumlah_keluar' => [
        'type'       => 'INT',
        'constraint' => 7,
        'null'       => false,
      ],
      'kode_supplier' => [
        'type'       => 'VARCHAR',
        'constraint' => 36,
        'null'       => false,
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
    $this->forge->addKey('id_barang_keluar', true);
    $this->forge->addForeignKey(
      'kode_barang',
      'stok',
      'kode_barang',
      'CASCADE',
      'NO ACTION',
    );
    $this->forge->addForeignKey(
      'nama_barang',
      'barang',
      'nama_barang',
      'CASCADE',
      'CASCADE',
    );
    $this->forge->createTable('barang_keluar');

    // ignore the linter error
    $this->db->enableForeignKeyChecks();
  }

  public function down()
  {
    $this->forge->dropTable('barang_keluar');
  }
}
