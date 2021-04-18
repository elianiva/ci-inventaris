<?php

namespace App\Controllers;

use App\Models\Supplier;
use App\Models\Barang;

class Dashboard extends BaseController
{
  public function index()
  {
    $supplierModel = new Supplier();
    $barangModel = new Barang();

    $data = [
      "title" => "Dashboard | Inventaris",
      "heading" => "Dashboard",
      "total_supplier" => $supplierModel->countAllResults(),
      "total_barang" => $barangModel->countAllResults(),
    ];

    return view("dashboard/index", $data);
  }
}
