<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangKeluar extends Model
{
  protected $table = "keluar_barang";
  protected $primaryKey = "id_keluar_barang";
  protected $useAutoIncrement = false;
  protected $useTimestamps = true;
  protected $createdField = "created_at";
  protected $updatedField = "updated_at";
  protected $allowedFields = [
    "id_keluar_barang",
    "kode_barang",
    "nama_barang",
    "tanggal_keluar",
    "jumlah_keluar",
    "kode_supplier",
  ];
}
