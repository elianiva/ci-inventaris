<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Main extends Seeder {
  public function run()
  {
    $db = \Config\Database::connect();
    $db->disableForeignKeyChecks();

    // clean the data before seeding
    $db->table("supplier")->truncate();
    $db->table("user")->truncate();
    $db->table("barang")->truncate();
    $db->table("barang_masuk")->truncate();
    $db->table("barang_keluar")->truncate();
    $db->table("stok")->truncate();

    $db->enableForeignKeyChecks();

    $this->call("Supplier");
    $this->call("User");
    $this->call("Barang");
    $this->call("BarangMasuk");
    $this->call("BarangKeluar");
    // $this->call("Stok");
  }
}
