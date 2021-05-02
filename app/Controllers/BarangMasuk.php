<?php

namespace App\Controllers;

use App\Models\BarangMasuk as BarangMasukModel;
use App\Models\Barang as BarangModel;
use App\Models\Stok as StokModel;
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

    return view('barang/keluar/tambah', $data);
  }

  public function save()
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

    $barang_keluar_model = new BarangMasukModel();
    $stok_model = new StokModel();

    $nama_barang = $request->getVar('name');
    $date = date('Y-m-d H:i:s', strtotime($request->getVar('date')));
    $total = $request->getVar('total');
    $nama_supplier = $request->getVar('supplier');

    $builder = $this->db->table('supplier');
    $kode_supplier = $builder
      ->where('nama_supplier', $nama_supplier)
      ->get(1)
      ->getResult()[0]->kode_supplier;

    $builder = $this->db->table('barang');
    $kode_barang = $builder
      ->where('nama_barang', $nama_barang)
      ->get(1)
      ->getResult()[0]->kode_barang;

    $builder = $this->db->table('stok');
    $stok = $builder
      ->where('nama_barang', $nama_barang)
      ->get(1)
      ->getResultArray()[0];
    $stok['total_barang'] =
      (string) ((int) $stok['total_barang'] + (int) $total);
    $stok['jumlah_barang_keluar'] =
      (string) ((int) $stok['jumlah_barang_keluar'] + (int) $total);

    // this method already handles `insert` and `update`
    // depending on the primary key
    $barang_keluar_model->save([
      'id_barang_keluar' => \Faker\Factory::create()->ean8(),
      'kode_barang' => $kode_barang,
      'nama_barang' => $nama_barang,
      'tanggal_keluar' => $date,
      'jumlah_keluar' => $total,
      'kode_supplier' => $kode_supplier,
    ]);

    $stok_model->save($stok);

    $this->session->setFlashData(
      'message',
      "Barang bernama '$nama_barang' telah berhasil ditambahkan!"
    );

    return redirect()->to('/barang-keluar');
  }

  public function hapus(string $id)
  {
    $barang_keluar_model = new BarangMasukModel();
    $stok_model = new StokModel();

    $barang = $barang_keluar_model->find($id);
    $nama_barang = $barang['nama_barang'];
    $builder = $this->db->table('stok');
    $stok = $builder
      ->where('kode_barang', $barang['kode_barang'])
      ->get(1)
      ->getResultArray()[0];
    $stok['total_barang'] =
      (string) ((int) $stok['total_barang'] + (int) $barang['jumlah_keluar']);
    $stok['jumlah_barang_keluar'] =
      (string) ((int) $stok['jumlah_barang_keluar'] -
        (int) $barang['jumlah_keluar']);

    $barang_keluar_model->delete($id);
    $stok_model->save($stok);

    $this->session->setFlashData(
      'message',
      "Log barang keluar bernama '$nama_barang' telah berhasil dihapus!"
    );

    return redirect()->to('/barang-keluar');
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

    $builder = $this->db->table('barang_keluar');
    $barangData = $builder
      ->orderBy($orderBy ? $orderBy : '', $dir ? $dir : '')
      ->join('supplier', 'supplier.kode_supplier = barang_keluar.kode_supplier')
      ->like('nama_barang', $keyword)
      ->orLike('jumlah_keluar', $keyword)
      ->orLike('nama_supplier', $keyword)
      ->select(
        'id_barang_keluar, nama_barang, nama_supplier, tanggal_keluar, jumlah_keluar'
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
      ])
    );
    $response->send();
  }
}
