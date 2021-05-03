<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
  protected $table = "user";
  protected $primaryKey = "kode_supplier";
  protected $useAutoIncrement = false;
  protected $useTimestamps = true;
  protected $createdField = "created_at";
  protected $updatedField = "updated_at";
  protected $allowedFields = [
    "id_user",
    "nama",
    "username",
    "password",
    "level",
  ];
}
