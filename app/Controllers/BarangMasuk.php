<?php

namespace App\Controllers;

use App\Models\BarangMasuk as BarangModel;

class BarangMasuk extends BaseController
{
  public function index()
  {
    $data = [
      "title" => "Barang Masuk | Inventaris",
      "heading" => "Barang Masuk",
      "page_name" => "barang",
    ];

    return view("barang/index", $data);
  }

  public function tambah()
  {
    $barangModel = new BarangModel();
    $categories = array_unique($barangModel->findColumn("kategori"));
    $kinds = array_unique($barangModel->findColumn("jenis_barang"));
    $sources = array_unique($barangModel->findColumn("sumber_dana"));

    $data = [
      "title" => "Barang | Inventaris",
      "heading" => "Barang",
      "page_name" => "barang",
      "title" => "Tambah",
      "categories" => $categories,
      "kinds" => $kinds,
      "sources" => $sources,
      "validation" => $this->validator,
    ];

    return view("barang/tambah", $data);
  }

  public function save(string $id = null)
  {
    /**
     * @var \Config\Services::request() $request Incoming request
     */
    $request = $this->request;

    $rules = [
      "name" => [
        "label" => "Nama Barang",
        "rules" => $id ? "required" : "required|is_unique[barang.nama_barang]",
      ],
      "spec" => [
        "label" => "Spesifikasi",
        "rules" => "required",
      ],
      "address" => [
        "label" => "Lokasi Barang",
        "rules" => "required",
      ],
      "category" => [
        "label" => "Kategori Barang",
        "rules" => "required",
      ],
      "total" => [
        "label" => "Jumlah Barang",
        "rules" => "required",
      ],
      "kind" => [
        "label" => "Jenis Barang",
        "rules" => "required",
      ],
      "source" => [
        "label" => "Sumber Dana",
        "rules" => "required",
      ],
    ];

    $errors = [
      "name" => [
        "required" => "Nama Barang tidak boleh kosong!",
        "is_unique" => "Nama Barang sudah terdaftar",
      ],
      "spec" => [
        "required" => "Spesifikasi tidak boleh kosong!",
      ],
      "address" => [
        "requied" => "Lokasi Barang tidak boleh kosong!",
      ],
      "category" => [
        "required" => "Kategori Barang tidak boleh kosong!",
      ],
      "total" => [
        "required" => "Jumlah Barang tidak boleh kosong!",
      ],
      "kind" => [
        "required" => "Jenis Barang tidak boleh kosong!",
      ],
      "source" => [
        "required" => "Sumber Dana tidak boleh kosong!",
      ],
    ];

    if (!$this->validate($rules, $errors)) {
      session()->setFlashData("errors", $this->validator->getErrors());
      return redirect()->to("/barang/tambah")->withInput();
    }

    $barangModel = new BarangModel();
    $nama = $request->getVar("name");

    // this method already handles `insert` and `update`
    // depending on the primary key
    $barangModel->save([
      "kode_barang" => $id ?? \Faker\Factory::create()->ean8(),
      "nama_barang" => $nama,
      "spesifikasi" => $request->getVar("spec"),
      "lokasi_barang" => $request->getVar("address"),
      "kategori" => $request->getVar("category"),
      "jumlah_barang" => $request->getVar("total"),
      "kondisi" => $request->getVar("condition"),
      "jenis_barang" => $request->getVar("kind"),
      "sumber_dana" => $request->getVar("source"),
    ]);

    session()->setFlashData(
      "message",
      sprintf(
        "Barang bernama '$nama' telah berhasil %s!",
        $id ? "diperbarui" : "ditambahkan"
      ),
    );

    return redirect()->to("/barang");
  }

  public function hapus(string $id)
  {
    $barangModel = new BarangModel();
    $nama = $barangModel->find($id)["nama_barang"];
    $barangModel->delete($id);

    session()->setFlashData(
      "message",
      "Barang bernama '$nama' telah berhasil dihapus!",
    );

    return redirect()->to("/barang");
  }

  public function edit(string $id)
  {
    $barangModel = new BarangModel();
    $categories = array_unique($barangModel->findColumn("kategori"));
    $kinds = array_unique($barangModel->findColumn("jenis_barang"));
    $sources = array_unique($barangModel->findColumn("sumber_dana"));
    $prev = $barangModel->find($id);

    $data = [
      "title" => "Supplier | Inventaris",
      "heading" => "Supplier",
      "page_name" => "supplier",
      "title" => "Edit",
      "categories" => $categories,
      "kinds" => $kinds,
      "sources" => $sources,
      "validation" => $this->validator,
      "prev" => $prev,
    ];

    return view("barang/tambah", $data);
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
