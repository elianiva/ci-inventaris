<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
  public function up()
  {
    $this->forge->addField([
      "id_user" => [
        "type" => "INT",
        "constraint" => 8,
        "auto_increment" => true,
        "null" => false,
      ],
      "nama" => [
        "type" => "VARCHAR",
        "constraint" => 35,
        "null" => false,
      ],
      "username" => [
        "type" => "VARCHAR",
        "constraint" => 15,
        "null" => false,
      ],
      "password" => [
        "type" => "VARCHAR",
        "constraint" => 64, // we'd use bcrypt; hence we need 64 limit
        "null" => false,
      ],
      "level" => [
        "type" => "INT",
        "constraint" => 1,
        "unsigned" => true,
        "null" => false,
      ],
    ]);
    $this->forge->addKey("id_user", true);
    $this->forge->createTable("user");
  }

  public function down()
  {
    $this->forge->dropTable("user");
  }
}
