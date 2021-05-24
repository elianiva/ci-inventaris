<?php

namespace App\Models;

use CodeIgniter\Model;

class Stok extends Model
{
  protected $table = 'stok';
  protected $primaryKey = 'kode_barang';
  protected $useAutoIncrement = false;
  protected $useTimestamps = true;
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $allowedFields = [
    'kode_barang',
    'nama_barang',
    'jumlah_barang_masuk',
    'jumlah_barang_keluar',
    'total_barang',
    'keterangan',
  ];
}
