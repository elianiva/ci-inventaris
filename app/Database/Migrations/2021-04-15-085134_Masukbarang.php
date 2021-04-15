<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Masukbarang extends Migration
{
  public function up()
  {
    $this->forge->addField([
      "id_masuk_barang" => [
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
      "tanggal_masuk" => [
        "type" => "DATE",
        "null" => false,
      ],
      "jumlah_masuk" => [
        "type" => "INT",
        "constraint" => 7,
        "null" => false,
      ],
      "kode_supplier" => [
        "type" => "VARCHAR",
        "constraint" => 5,
        "null" => false,
      ],
    ]);
    $this->forge->addKey("id_masuk_barang", true);
    $this->forge->addForeignKey(
      "kode_barang",
      "stok",
      "kode_barang",
      "CASCADE",
      "NO ACTION",
    );
    $this->forge->addForeignKey(
      "jumlah_masuk",
      "stok",
      "jumlah_barang_masuk",
      "CASCADE",
      "NO ACTION",
    );
    $this->forge->addForeignKey(
      "kode_supplier",
      "supplier",
      "kode_supplier",
      "CASCADE",
      "NO ACTION",
    );
    $this->forge->createTable("masuk_barang");
  }

  public function down()
  {
    $this->forge->dropTable("masuk_barang");
  }
}