<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
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
      "spesifikasi" => [
        "type" => "VARCHAR",
        "constraint" => 35,
        "null" => false,
      ],
      "lokasi_barang" => [
        "type" => "VARCHAR",
        "constraint" => 40,
        "null" => false,
      ],
      "kategori" => [
        "type" => "VARCHAR",
        "constraint" => 25,
        "null" => false,
      ],
      "kondisi" => [
        "type" => "VARCHAR",
        "constraint" => 20,
        "null" => false,
      ],
      "jenis_barang" => [
        "type" => "VARCHAR",
        "constraint" => 20,
        "null" => false,
      ],
      "sumber_dana" => [
        "type" => "VARCHAR",
        "constraint" => 25,
        "null" => false,
      ],
      "created_at" => [
        "type" => "DATETIME",
        "null" => false,
      ],
      "updated_at" => [
        "type" => "DATETIME",
        "null" => false,
      ],
    ]);
    $this->forge->addKey("kode_barang", true);
    $this->forge->addKey("nama_barang");
    $this->forge->createTable("barang");
  }

  public function down()
  {
    $this->forge->dropTable("barang");
  }
}
