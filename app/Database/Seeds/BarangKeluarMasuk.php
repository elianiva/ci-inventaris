<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

use App\Models\Barang as BarangModel;
use App\Models\Supplier as SupplierModel;

class BarangKeluarMasuk extends Seeder
{
  public function run()
  {
    $this->db->disableForeignKeyChecks();

    $faker = \Faker\Factory::create('id_ID');
    $faker->seed(1234);

    $barang_model = new BarangModel();
    $supplier_model = new SupplierModel();
    $kode_barang_s = $barang_model->findColumn('kode_barang');
    $kode_supplier_s = $supplier_model->findColumn('kode_supplier');

    for ($i = 0; $i < 50; $i++) {
      $kode_barang = $faker->randomElement($kode_barang_s);
      // remove used `kode_barang`
      if (($key = array_search($kode_barang, $kode_barang_s)) !== false) {
        unset($kode_barang_s[$key]);
      }

      $kode_supplier = $faker->randomElement($kode_supplier_s);
      $name = $barang_model->find($kode_barang)['nama_barang'];

      $jumlah_masuk = $faker->numberBetween(50, 200);
      $date = $faker->date();

      $masuk = [
        'id_barang_masuk' => $faker->ean8(),
        'kode_barang' => $kode_barang,
        'nama_barang' => $name,
        'tanggal_masuk' => $date,
        'jumlah_masuk' => $jumlah_masuk,
        'kode_supplier' => $kode_supplier,
        'created_at' => Time::now(),
        'updated_at' => Time::now(),
      ];

      $keluar = [
        'id_barang_keluar' => $faker->ean8(),
        'kode_barang' => $kode_barang,
        'nama_barang' => $name,
        'tanggal_keluar' => $date,
        'jumlah_keluar' => $faker->numberBetween(0, $jumlah_masuk),
        'kode_supplier' => $kode_supplier,
        'created_at' => Time::now(),
        'updated_at' => Time::now(),
      ];

      $this->db->table('barang_masuk')->insert($masuk);
      $this->db->table('barang_keluar')->insert($keluar);
    }

    $this->db->enableForeignKeyChecks();
  }
}
