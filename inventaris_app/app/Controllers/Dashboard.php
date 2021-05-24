<?php

namespace App\Controllers;

use App\Models\Supplier;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Stok;

class Dashboard extends BaseController
{
  public function index()
  {
    $supplier_model = new Supplier();
    $barang_model = new Barang();
    $barang_masuk_model = new BarangMasuk();
    $barang_keluar_model = new BarangKeluar();
    $stok_model = new Stok();
    $total_stok = $stok_model
      ->builder()
      ->selectSum('total_barang')
      ->get()
      ->getResult()[0]->total_barang;

    $data = [
      'title'               => 'Dashboard',
      'heading'             => 'Dashboard',
      'total_supplier'      => $supplier_model->countAllResults(),
      'total_barang'        => $barang_model->countAllResults(),
      'total_barang_masuk'  => $barang_masuk_model->countAllResults(),
      'total_barang_keluar' => $barang_keluar_model->countAllResults(),
      'total_stok'          => $total_stok,
      'page_name'           => 'dashboard',
    ];

    return view('dashboard/index', $data);
  }
}
