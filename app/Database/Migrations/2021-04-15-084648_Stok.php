<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Stok extends Migration
{
  public function up()
  {
    $this->forge->addField([
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
      "jumlah_barang_masuk" => [
        "type" => "INT",
        "constraint" => 7,
        "null" => false,
      ],
      "jumlah_barang_keluar" => [
        "type" => "INT",
        "constraint" => 7,
        "null" => false,
      ],
      "total_barang" => [
        "type" => "INT",
        "constraint" => 8,
        "null" => false,
      ],
      "keterangan" => [
        "type" => "VARCHAR",
        "constraint" => 25,
        "null" => true,
      ],
    ]);
    $this->forge->addKey("kode_barang", true);
    $this->forge->createTable("stok");
  }

  public function down()
  {
    $this->forge->dropTable("stok");
  }
}
