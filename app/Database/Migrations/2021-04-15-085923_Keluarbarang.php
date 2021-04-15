<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Keluarbarang extends Migration
{
  public function up()
  {
    $this->forge->addField([
      "id_keluar_barang" => [
        "type" => "VARCHAR",
        "constraint" => 8,
        "null" => false,
      ],
      "kode_barang" => [
        "type" => "VARCHAR",
        "constraint" => 8,
        "null" => false,
      ],
      "nama_barang" => [
        "type" => "VARCHAR",
        "constraint" => 30,
        "null" => false,
      ],
      "tanggal_keluar" => [
        "type" => "DATE",
        "null" => false,
      ],
      "jumlah_keluar" => [
        "type" => "INT",
        "constraint" => 7,
        "null" => false,
      ],
      "kode_supplier" => [
        "type" => "INT",
        "constraint" => 5,
        "null" => false,
      ],
    ]);
    $this->forge->addKey("id_keluar_barang", true);
    $this->forge->addForeignKey(
      "kode_barang",
      "stok",
      "kode_barang",
      "CASCADE",
      "NO ACTION",
    );
    $this->forge->addForeignKey(
      "jumlah_keluar",
      "stok",
      "jumlah_barang_keluar",
      "CASCADE",
      "NO ACTION",
    );
    $this->forge->createTable("keluar_barang");
  }

  public function down()
  {
    $this->forge->dropTable("keluar_barang");
  }
}
