<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangKeluar extends Model
{
  protected $table = 'barang_keluar';
  protected $primaryKey = 'id_barang_keluar';
  protected $useAutoIncrement = false;
  protected $useTimestamps = true;
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $allowedFields = [
    'id_barang_keluar',
    'kode_barang',
    'nama_barang',
    'tanggal_keluar',
    'jumlah_keluar',
    'kode_supplier',
  ];
}
