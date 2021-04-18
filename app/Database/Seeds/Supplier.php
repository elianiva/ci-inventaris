<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Supplier extends Seeder
{
  public function run()
  {
    $faker = \Faker\Factory::create("id_ID");
    $faker->seed(1234);

    for ($i = 0; $i < 20; $i++) {
      $data = [
        "kode_supplier" => strtoupper($faker->lexify("????")),
        "nama_supplier" => $faker->name(),
        "alamat_supplier" => $faker->address(),
        "telp_supplier" => $faker->phoneNumber(),
        "kota_supplier" => $faker->city(),
      ];
      $this->db->table("supplier")->insert($data);
    }
  }
}
