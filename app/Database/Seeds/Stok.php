<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

use App\Models\Barang as BarangModel;
use App\Models\BarangMasuk as BarangMasukModel;
use App\Models\BarangKeluar as BarangKeluarModel;

class Stok extends Seeder
{
  public function run()
  {
    $faker = \Faker\Factory::create("id_ID");
    $faker->seed(1234);

    $barang_model = new BarangModel();
    $barang_masuk_model = new BarangMasukModel();
    $barang_keluar_model = new BarangKeluarModel();
    $kode_barang = $barang_model->findColumn("kode_barang");

    for ($i = 0; $i < 50; $i++) {
      $rand = $faker->randomElement($kode_barang);
      $nama_barang = $barang_model->find($rand)["nama_barang"];

      // I dislike this copypasta...
      $jumlah_masuk = $barang_masuk_model
        ->builder()
        ->select("nama_barang, jumlah_masuk")
        ->getWhere(["kode_barang" => $rand])
        ->getResult();
      $jumlah_masuk = array_reduce(
        $jumlah_masuk,
        fn($acc, $curr) => ($acc += $curr->jumlah_masuk),
        0,
      );

      // I dislike this copypasta...
      $jumlah_keluar = $barang_keluar_model
        ->builder()
        ->select("nama_barang, jumlah_keluar")
        ->getWhere(["kode_barang" => $rand])
        ->getResult();
      $jumlah_keluar = array_reduce(
        $jumlah_keluar,
        fn($acc, $curr) => ($acc += $curr->jumlah_keluar),
        0,
      );

      $data = [
        "kode_barang" => $rand,
        "nama_barang" => $nama_barang,
        "jumlah_barang_masuk" => $jumlah_masuk,
        "jumlah_barang_keluar" => $jumlah_keluar,
        "created_at" => Time::now(),
        "updated_at" => Time::now(),
      ];
      $this->db->table("stok")->insert($data);
    }
  }
}
