<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pinjambarang extends Migration
{
  public function up()
  {
    $this->forge->addField([
      "no_pinjam" => [
        "type" => "VARCHAR",
        "constraint" => 8,
        "null" => false,
      ],
      "tanggal_pinjam" => [
        "type" => "DATE",
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
      "jumlah_pinjam" => [
        "type" => "INT",
        "constraint" => 7,
        "null" => false,
      ],
      "peminjam" => [
        "type" => "VARCHAR",
        "constraint" => 35,
        "null" => false,
      ],
      "tanggal_kembali" => [
        "type" => "DATE",
        "null" => false,
      ],
      "keterangan" => [
        "type" => "VARCHAR",
        "constraint" => 30,
        "null" => true,
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
    $this->forge->addKey("no_pinjam", true);
    $this->forge->addForeignKey(
      "kode_barang",
      "keluar_barang",
      "kode_barang",
      "CASCADE",
      "NO ACTION",
    );
    $this->forge->createTable("pinjam_barang");
  }

  public function down()
  {
    $this->forge->dropTable("pinjam_barang");
  }
}
