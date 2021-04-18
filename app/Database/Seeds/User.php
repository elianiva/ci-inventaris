<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class User extends Seeder
{
  public function run()
  {
    $faker = \Faker\Factory::create("id_ID");
    $faker->seed(1234);

    $gen_pass = fn(string $pass): string => password_hash($pass, PASSWORD_BCRYPT);

    $data = [
      [
        "nama" => $faker->name(),
        "username" => "admin",
        "password" => $gen_pass("admin"),
        "level" => 1,
      ],
      [
        "nama" => $faker->name(),
        "username" => "user",
        "password" => $gen_pass("user"),
        "level" => 2,
      ],
      [
        "nama" => $faker->name(),
        "username" => "user_asdf",
        "password" => $gen_pass("user_asdf"),
        "level" => 2,
      ],
    ];
    $this->db->table("user")->insertBatch($data);
  }
}
