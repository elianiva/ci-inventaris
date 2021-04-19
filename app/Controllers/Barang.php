<?php

namespace App\Controllers;

class Barang extends BaseController
{
  public function index()
  {
    $data = [
      "title" => "Barang | Inventaris",
      "heading" => "Barang",
      "page_name" => "barang",
    ];

    return view("barang/index", $data);
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
    $builder = $db->table("barang");

    $barangData = $builder
      ->orderBy($orderBy ? $orderBy : "", $dir ? $dir : "")
      ->like("nama_barang", $keyword)
      ->orLike("spesifikasi", $keyword)
      ->orLike("lokasi_barang", $keyword)
      ->orLike("jenis_barang", $keyword)
      ->orLike("sumber_dana", $keyword)
      ->orLike("kategori", $keyword)
      ->orLike("kondisi", $keyword)
      ->get($limit, $offset)
      ->getResult();
    $dataSize = sizeof($barangData);
    $allResults = $builder->countAllResults();

    // we need to do this do gridjs knows the actual count after we
    // do something like `search`
    $barangTotal =
      $dataSize == 0 ? 0 : ($keyword == null ? $allResults : $dataSize);

    $response = service("response");
    $response->setHeader("Content-Type", "application/json");
    $response->setBody(
      json_encode([
        "results" => $barangData,
        "count" => $barangTotal,
      ]),
    );
    $response->send();
  }
}
