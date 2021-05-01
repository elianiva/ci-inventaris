<?php

namespace App\Controllers;

use App\Models\BarangKeluar as BarangKeluarModel;
use App\Models\Barang as BarangModel;
use App\Models\Supplier as SupplierModel;

class BarangKeluar extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Barang Keluar | Inventaris',
      'heading' => 'Barang Keluar',
      'page_name' => 'barang',
    ];

    return view('barang/keluar/index', $data);
  }

  public function tambah()
  {
    $barang_model = new BarangModel();
    $supplier_model = new SupplierModel();
    $barang = $barang_model->findColumn('nama_barang');
    $supplier = $supplier_model->findColumn('nama_supplier');

    $data = [
      'title' => 'Barang Keluar | Inventaris',
      'heading' => 'Barang Keluar',
      'page_name' => 'barang',
      'title' => 'Tambah',
      'barang' => $barang,
      'supplier' => $supplier,
    ];

    return view('barang/keluar/tambah', $data);
  }

  public function save(string $id = null)
  {
    /**
     * @var \Config\Services::request() $request Incoming request
     */
    $request = $this->request;

    $rules = [
      'name' => [
        'label' => 'Nama Barang',
        'rules' => 'required',
      ],
      'date' => [
        'label' => 'Tanggal keluar',
        'rules' => 'required',
      ],
      'supplier' => [
        'label' => 'Nama Supplier',
        'rules' => 'required',
      ],
      'total' => [
        'label' => 'Jumlah Barang',
        'rules' => 'required',
      ],
    ];

    $errors = [
      'name' => [
        'required' => 'Nama Barang tidak boleh kosong!',
      ],
      'date' => [
        'required' => 'Tanggal keluar tidak boleh kosong!',
      ],
      'supplier' => [
        'required' => 'Nama Supplier tidak boleh kosong!',
      ],
      'total' => [
        'required' => 'Jumlah Barang tidak boleh kosong!',
      ],
    ];

    if (!$this->validate($rules, $errors)) {
      $this->session->setFlashData('errors', $this->validator->getErrors());
      return redirect()
        ->to('/barang-keluar/tambah')
        ->withInput();
    }

    $barang_keluar_model = new BarangKeluarModel();
    $nama = $request->getVar('name');
    $date = date('Y-m-d H:i:s', strtotime($request->getVar('date')));
    $total = $request->getVar('total');
    $nama_supplier = $request->getVar('supplier');

    $db = \Config\Database::connect();
    $builder = $db->table('supplier');
    $kode_supplier = $builder
      ->where('nama_supplier', $nama_supplier)
      ->get(1)
      ->getResult()[0]->kode_supplier;

    // this method already handles `insert` and `update`
    // depending on the primary key
    $barang_keluar_model->save([
      'id_barang_keluar' => $id ?? \Faker\Factory::create()->ean8(),
      'kode_barang' => $nama,
      'nama_barang' => $nama,
      'tanggal_keluar' => $date,
      'jumlah_keluar' => $total,
      'kode_supplier' => $kode_supplier,
    ]);

    $this->session->setFlashData(
      'message',
      sprintf(
        "Barang bernama '$nama' telah berhasil %s!",
        $id ? 'diperbarui' : 'ditambahkan',
      ),
    );

    return redirect()->to('/barang-keluar');
  }

  public function hapus(string $id)
  {
    $barang_keluar_model = new BarangKeluarModel();
    $nama = $barang_keluar_model->find($id)['nama_barang'];
    $barang_keluar_model->delete($id);

    $this->session->setFlashData(
      'message',
      "Log barang keluar bernama '$nama' telah berhasil dihapus!",
    );

    return redirect()->to('/barang-keluar');
  }

  public function edit(string $id)
  {
    $barang_keluar_model = new BarangKeluarModel();
    $categories = array_unique($barang_keluar_model->findColumn('kategori'));
    $kinds = array_unique($barang_keluar_model->findColumn('jenis_barang'));
    $sources = array_unique($barang_keluar_model->findColumn('sumber_dana'));
    $prev = $barang_keluar_model->find($id);

    $data = [
      'title' => 'Supplier | Inventaris',
      'heading' => 'Supplier',
      'page_name' => 'supplier',
      'title' => 'Edit',
      'categories' => $categories,
      'kinds' => $kinds,
      'sources' => $sources,
      'validation' => $this->validator,
      'prev' => $prev,
    ];

    return view('barang/keluar/tambah', $data);
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

    $db = \Config\Database::connect();
    $builder = $db->table('barang_keluar');

    $barangData = $builder
      ->orderBy($orderBy ? $orderBy : '', $dir ? $dir : '')
      ->join('supplier', 'supplier.kode_supplier = barang_keluar.kode_supplier')
      ->like('nama_barang', $keyword)
      ->orLike('jumlah_keluar', $keyword)
      ->orLike('nama_supplier', $keyword)
      ->select(
        'id_barang_keluar, nama_barang, nama_supplier, tanggal_keluar, jumlah_keluar',
      )
      ->get($limit, $offset)
      ->getResult();
    $dataSize = sizeof($barangData);
    $allResults = $builder->countAllResults();

    // we need to do this do gridjs knows the actual count after we
    // do something like `search`
    $barangTotal =
      $dataSize == 0 ? 0 : ($keyword == null ? $allResults : $dataSize);

    $response = service('response');
    $response->setHeader('Content-Type', 'application/json');
    $response->setBody(
      json_encode([
        'results' => $barangData,
        'count' => $barangTotal,
      ]),
    );
    $response->send();
  }
}

