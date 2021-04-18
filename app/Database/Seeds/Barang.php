<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Barang extends Seeder
{
  public function run()
  {
    $faker = \Faker\Factory::create("id_ID");
    $faker->seed(1234);

    for ($i = 0; $i < 50; $i++) {
      $data = [
        "kode_barang" => $faker->ean8(),
        "nama_barang" => ucfirst($faker->word()),
        "spesifikasi" => $faker->sentence(4),
        "lokasi_barang" => $faker->streetAddress(),
        "kategori" => $faker->randomElement([
          "Pendidikan",
          "Teknologi",
          "Kesenian",
          "Lainnya",
        ]),
        "jumlah_barang" => $faker->numberBetween(0, 100),
        "kondisi" => $faker->randomElement([
          "Baik",
          "Kurang Baik",
          "Tidak Baik",
        ]),
        "jenis_barang" => $faker->randomElement([
          "Alat Tulis Kantor",
          "Lainnya",
        ]),
        "sumber_dana" => $faker->randomElement([
          "Dana Sekolah",
          "Dana Bansos",
          "Lainnya",
        ]),
        "created_at" => Time::now(),
        "updated_at" => Time::now(),
      ];

      $this->db->table("barang")->insert($data);
    }
  }
}
