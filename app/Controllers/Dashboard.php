<?php

namespace App\Controllers;

use App\Models\Supplier;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class Dashboard extends BaseController
{
  public function index()
  {
    $supplierModel = new Supplier();
    $barangModel = new Barang();
    $barangMasukModel = new BarangMasuk();
    $barangKeluarModel = new BarangKeluar();

    $data = [
      "title" => "Dashboard | Inventaris",
      "heading" => "Dashboard",
      "total_supplier" => $supplierModel->countAllResults(),
      "total_barang" => $barangModel->countAllResults(),
      "total_barang_masuk" => $barangMasukModel->countAllResults(),
      "total_barang_keluar" => $barangKeluarModel->countAllResults(),
      "page_name" => "dashboard"
    ];

    return view("dashboard/index", $data);
  }
}
