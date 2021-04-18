<?php

namespace App\Controllers;

class Supplier extends BaseController
{
  public function index()
  {
    $data = [
      "title" => "Supplier | Inventaris",
      "heading" => "Dashboard",
      "page_name" => "supplier",
    ];

    return view("supplier/index", $data);
  }

  public function getAll()
  {
    $request = \Config\Services::request();
    $limit = (int) $request->getVar("limit");
    $offset = (int) $request->getVar("offset");
    $orderBy = $request->getVar("order");
    $dir = $request->getVar("dir");
    $keyword = $request->getVar("search");
    $keyword = $keyword ? $keyword : "";

    $db = \Config\Database::connect();
    $builder = $db->table("supplier");

    $supplierData = $builder
      ->orderBy($orderBy ? $orderBy : "", $dir ? $dir : "")
      ->like("nama_supplier", $keyword)
      ->orLike("alamat_supplier", $keyword)
      ->orLike("telp_supplier", $keyword)
      ->orLike("kota_supplier", $keyword)
      ->get($limit, $offset)
      ->getResult();
    $supplierTotal = $builder->countAllResults();

    $response = service("response");
    $response->setHeader("Content-Type", "application/json");
    $response->setBody(
      json_encode([
        "results" => $supplierData,
        "count" => $supplierTotal,
      ]),
    );
    $response->send();
  }
}
