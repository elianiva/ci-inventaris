<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasuk extends Model
{
  protected $table = 'barang_masuk';
  protected $primaryKey = 'id_barang_masuk';
  protected $useAutoIncrement = false;
  protected $useTimestamps = true;
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $allowedFields = [
    'id_barang_masuk',
    'kode_barang',
    'nama_barang',
    'tanggal_masuk',
    'jumlah_masuk',
    'kode_supplier',
  ];
}
