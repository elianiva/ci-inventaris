<?php

namespace App\Controllers;

use App\Models\Supplier as SupplierModel;

class Supplier extends BaseController
{
  public function index()
  {
    $data = [
      "title" => "Supplier | Inventaris",
      "heading" => "Supplier",
      "page_name" => "supplier",
    ];

    return view("supplier/index", $data);
  }

  public function form()
  {
    $supplierModel = new SupplierModel();
    $categories = array_unique($supplierModel->findColumn("kota_supplier"));

    $data = [
      "title" => "Supplier | Inventaris",
      "heading" => "Supplier",
      "page_name" => "supplier",
      "categories" => $categories,
      "validation" => $this->validator,
    ];

    return view("supplier/tambah", $data);
  }

  public function save()
  {
    /**
     * @var \Config\Services::request() $request Incoming request
     */
    $request = $this->request;

    $rules = [
      "name" => [
        "label" => "Nama Supplier",
        "rules" => "required|is_unique[supplier.nama_supplier]",
      ],
      "address" => [
        "label" => "Alamat Supplier",
        "rules" => "required|is_unique[supplier.alamat_supplier]",
      ],
      "telp" => [
        "label" => "no. Telepon Supplier",
        "rules" => "required|is_unique[supplier.telp_supplier]",
      ],
      "city" => [
        "label" => "Kota Supplier",
        "rules" => "required",
      ],
    ];

    $errors = [
      "name" => [
        "required" => "Nama Supplier tidak boleh kosong!",
        "is_unique" => "Nama Supplier sudah terdaftar!",
      ],
      "address" => [
        "required" => "Alamat Supplier tidak boleh kosong!",
        "is_unique" => "Alamat Supplier sudah terdaftar!",
      ],
      "telp" => [
        "required" => "No. Telepon Supplier tidak boleh kosong!",
        "is_unique" => "No. Telepon Supplier sudah terdaftar!",
      ],
      "city" => [
        "required" => "Kota Supplier tidak boleh kosong!",
      ],
    ];

    // if (!$this->validate($rules, $errors)) {
    //   return redirect()->to("/supplier/tambah");
    // }

    $supplierModel = new SupplierModel();
    $supplierModel->save([
      "kode_supplier" => \Faker\Factory::create()->lexify("????"),
      "nama_supplier" => $request->getVar("name"),
      "alamat_supplier" => $request->getVar("address"),
      "telp_supplier" => $request->getVar("telp"),
      "kota_supplier" => $request->getVar("city"),
    ]);

    return redirect()->to("/supplier");
  }

  public function hapus(string $id)
  {
    $supplierModel = new SupplierModel();
    $supplierModel->delete($id);

    session()->setFlashData("message", "Data telah berhasil dihapus!");

    return redirect()->to("/supplier");
  }

  public function getAll()
  {
    /**
     * @var \Config\Services::request() $request Incoming request
     */
    $request = $this->request;

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
    $dataSize = sizeof($supplierData);
    $allResults = $builder->countAllResults();

    // we need to do this do gridjs knows the actual count after we
    // do something like `search`
    $supplierTotal =
      $dataSize == 0 ? 0 : ($keyword == null ? $allResults : $dataSize);

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
