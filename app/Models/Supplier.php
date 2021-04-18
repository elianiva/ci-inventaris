<?php

namespace App\Models;

use CodeIgniter\Model;

class Supplier extends Model
{
  protected $table = "supplier";
  protected $primaryKey = "kode_supplier";
  protected $useAutoIncrement = false;
  protected $useTimestamps = true;
  protected $createdField = "created_at";
  protected $updatedField = "updated_at";
}
