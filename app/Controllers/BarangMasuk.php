<?php

namespace App\Controllers;

use App\Models\BarangMasuk as BarangMasukModel;
use App\Models\Barang as BarangModel;
use App\Models\Supplier as SupplierModel;

class BarangMasuk extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Barang Masuk',
      'heading' => 'Barang Masuk',
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
      'title' => 'Barang Masuk',
      'heading' => 'Barang Masuk',
      'page_name' => 'barang',
      'title' => 'Tambah',
      'barang' => $barang,
      'supplier' => $supplier,
    ];

    return view('barang/masuk/tambah', $data);
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
        'label' => 'Tanggal Masuk',
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
        'required' => 'Tanggal Masuk tidak boleh kosong!',
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
        ->to('/barang-masuk/tambah')
        ->withInput();
    }

    $barang_masuk_model = new BarangMasukModel();
    $nama = $request->getVar('name');
    $date = date('Y-m-d H:i:s', strtotime($request->getVar('date')));
    $total = $request->getVar('total');
    $nama_supplier = $request->getVar('supplier');

    $builder = $this->db->table('supplier');
    $kode_supplier = $builder
      ->where('nama_supplier', $nama_supplier)
      ->get(1)
      ->getResult()[0]->kode_supplier;

    // this method already handles `insert` and `update`
    // depending on the primary key
    $barang_masuk_model->save([
      'id_barang_masuk' => $id ?? \Faker\Factory::create()->ean8(),
      'kode_barang' => $nama,
      'nama_barang' => $nama,
      'tanggal_masuk' => $date,
      'jumlah_masuk' => $total,
      'kode_supplier' => $kode_supplier,
    ]);

    $this->session->setFlashData(
      'message',
      sprintf(
        "Barang bernama '$nama' telah berhasil %s!",
        $id ? 'diperbarui' : 'ditambahkan',
      ),
    );

    return redirect()->to('/barang-masuk');
  }

  public function hapus(string $id)
  {
    $barang_masuk_model = new BarangMasukModel();
    $nama = $barang_masuk_model->find($id)['nama_barang'];
    $barang_masuk_model->delete($id);

    $this->session->setFlashData(
      'message',
      "Log barang masuk bernama '$nama' telah berhasil dihapus!",
    );

    return redirect()->to('/barang-masuk');
  }

  public function edit(string $id)
  {
    $barang_masuk_model = new BarangMasukModel();
    $categories = array_unique($barang_masuk_model->findColumn('kategori'));
    $kinds = array_unique($barang_masuk_model->findColumn('jenis_barang'));
    $sources = array_unique($barang_masuk_model->findColumn('sumber_dana'));
    $prev = $barang_masuk_model->find($id);

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

    return view('barang/masuk/tambah', $data);
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
    $builder = $db->table('barang_masuk');

    $barangData = $builder
      ->orderBy($orderBy ? $orderBy : '', $dir ? $dir : '')
      ->join('supplier', 'supplier.kode_supplier = barang_masuk.kode_supplier')
      ->like('nama_barang', $keyword)
      ->orLike('jumlah_masuk', $keyword)
      ->orLike('nama_supplier', $keyword)
      ->select(
        'id_barang_masuk, nama_barang, nama_supplier, tanggal_masuk, jumlah_masuk',
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
