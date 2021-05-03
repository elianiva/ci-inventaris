<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Supplier extends Seeder
{
  public function run()
  {
    $faker = \Faker\Factory::create('id_ID');
    $faker->seed(1234);

    for ($i = 0; $i < 20; $i++) {
      $data = [
        'kode_supplier' => strtoupper($faker->lexify('????')),
        'nama_supplier' => $faker->name(),
        'alamat_supplier' => $faker->address(),
        'telp_supplier' => $faker->phoneNumber(),
        'kota_supplier' => $faker->city(),
        'created_at' => Time::now(),
        'updated_at' => Time::now(),
      ];
      $this->db->table('supplier')->insert($data);
    }
  }
}
