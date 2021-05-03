<?php

namespace App\Controllers;

class Stok extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Stok',
      'heading' => 'Stok',
      'page_name' => 'stok',
    ];

    return view('stok/index', $data);
  }

  public function get_all()
  {
    /**
     * @var \Config\Services::request() $request Incoming request
     */
    $request = $this->request;

    $limit = (int) $request->getVar('limit');
    $offset = (int) $request->getVar('offset');
    $orderBy = $request->getVar('order');
    $dir = $request->getVar('dir');
    $keyword = $request->getVar('search');
    $keyword = $keyword ? $keyword : '';

    $builder = $this->db->table('stok');

    $supplierData = $builder
      ->orderBy($orderBy ? $orderBy : '', $dir ? $dir : '')
      ->like('nama_barang', $keyword)
      ->orLike('total_barang', $keyword)
      ->orLike('jumlah_barang_masuk', $keyword)
      ->orLike('jumlah_barang_keluar', $keyword)
      ->get($limit, $offset)
      ->getResult();
    $dataSize = sizeof($supplierData);
    $allResults = $builder->countAllResults();

    // we need to do this do gridjs knows the actual count after we
    // do something like `search`
    $supplierTotal =
      $dataSize == 0 ? 0 : ($keyword == null ? $allResults : $dataSize);

    $response = service('response');
    $response->setHeader('Content-Type', 'application/json');
    $response->setBody(
      json_encode([
        'results' => $supplierData,
        'count' => $supplierTotal,
      ]),
    );
    $response->send();
  }
}
