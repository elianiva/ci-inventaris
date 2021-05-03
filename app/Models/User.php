<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
  protected $table = 'user';
  protected $primaryKey = 'id_user';
  protected $useAutoIncrement = true;
  protected $useTimestamps = true;
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $allowedFields = ['nama', 'username', 'password', 'level'];
}
