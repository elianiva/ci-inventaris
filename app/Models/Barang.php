<?php

namespace App\Models;

use CodeIgniter\Model;

class Barang extends Model
{
  protected $table = "barang";
  protected $primaryKey = "kode_barang";
  protected $useAutoIncrement = false;
  protected $useTimestamps = true;
  protected $createdField = "created_at";
  protected $updatedField = "updated_at";
  protected $allowedFields = [
    "kode_barang",
    "nama_barang",
    "spesifikasi",
    "lokasi_barang",
    "kategori",
    "jumlah_barang",
    "kondisi",
    "jenis_barang",
    "sumber_dana",
  ];
}
