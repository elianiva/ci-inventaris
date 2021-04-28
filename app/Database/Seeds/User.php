<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class User extends Seeder
{
  public function run()
  {
    $faker = \Faker\Factory::create("id_ID");
    $faker->seed(1234);

    $gen_pass = fn(string $pass) => password_hash($pass, PASSWORD_BCRYPT);

    $data = [
      [
        "nama" => $faker->name(),
        "username" => "admin",
        "password" => $gen_pass("admin"),
        "level" => 1,
        "created_at" => Time::now(),
        "updated_at" => Time::now(),
      ],
      [
        "nama" => $faker->name(),
        "username" => "user",
        "password" => $gen_pass("user"),
        "level" => 2,
        "created_at" => Time::now(),
        "updated_at" => Time::now(),
      ],
      [
        "nama" => $faker->name(),
        "username" => "user_asdf",
        "password" => $gen_pass("user_asdf"),
        "level" => 2,
        "created_at" => Time::now(),
        "updated_at" => Time::now(),
      ],
    ];
    $this->db->table("user")->insertBatch($data);
  }
}
