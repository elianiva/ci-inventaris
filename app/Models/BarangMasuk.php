<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasuk extends Model
{
  protected $table = "masuk_barang";
  protected $primaryKey = "id_masuk_barang";
  protected $useAutoIncrement = false;
  protected $useTimestamps = true;
  protected $createdField = "created_at";
  protected $updatedField = "updated_at";
  protected $allowedFields = [
    "id_masuk_barang",
    "kode_barang",
    "nama_barang",
    "tanggal_masuk",
    "jumlah_masuk",
    "kode_supplier",
  ];
}
