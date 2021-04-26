<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

use App\Models\Barang as BarangModel;
use App\Models\Supplier as SupplierModel;

class BarangKeluar extends Seeder
{
  public function run()
  {
    $this->db->disableForeignKeyChecks();

    $faker = \Faker\Factory::create("id_ID");
    $faker->seed(1234);

    $barang_model = new BarangModel();
    $supplier_model = new SupplierModel();
    $kode_barang = $barang_model->findColumn("kode_barang");
    $kode_supplier = $supplier_model->findColumn("kode_supplier");

    for ($i = 0; $i < 50; $i++) {
      $kode_barang_asdf = $faker->randomElement($kode_barang);
      $kode_supplier_asdf = $faker->randomElement($kode_supplier);
      $name = $barang_model->find($kode_barang_asdf)['nama_barang'];

      $data = [
        "id_barang_keluar" => $faker->ean8(),
        "kode_barang" => $kode_barang_asdf,
        "nama_barang" => $name,
        "tanggal_keluar" => $faker->date(),
        "jumlah_keluar" => $faker->numberBetween(0, 100),
        "kode_supplier" => $kode_supplier_asdf,
        "created_at" => Time::now(),
        "updated_at" => Time::now(),
      ];

      $this->db->table("barang_keluar")->insert($data);
    }

    $this->db->enableForeignKeyChecks();
  }
}
