<?php

namespace App\Controllers;

use App\Models\BarangMasuk as BarangMasukModel;
use App\Models\Barang as BarangModel;
use App\Models\Stok as StokModel;
use App\Models\Supplier as SupplierModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BarangMasuk extends BaseController
{
  public function index()
  {
    $data = [
      'title'     => 'Barang Masuk',
      'heading'   => 'Barang Masuk',
      'page_name' => 'barang',
    ];

    return view('barang/masuk/index', $data);
  }

  public function tambah()
  {
    $barang_model = new BarangModel();
    $supplier_model = new SupplierModel();
    $barang = $barang_model->findColumn('nama_barang');
    $supplier = $supplier_model->findColumn('nama_supplier');

    $data = [
      'title'     => 'Barang Masuk',
      'heading'   => 'Barang Masuk',
      'page_name' => 'barang',
      'title'     => 'Tambah',
      'barang'    => $barang,
      'supplier'  => $supplier,
    ];

    return view('barang/masuk/form', $data);
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
    $stok['jumlah_barang_masuk'] =
      (string) ((int) $stok['jumlah_barang_masuk'] + (int) $total);

    // this method already handles `insert` and `update`
    // depending on the primary key
    $barang_masuk_model->save([
      'id_barang_masuk' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
      'kode_barang'      => $kode_barang,
      'nama_barang'      => $nama_barang,
      'tanggal_masuk'   => $date,
      'jumlah_masuk'    => $total,
      'kode_supplier'    => $kode_supplier,
    ]);

    $stok_model->save($stok);

    $this->session->setFlashData(
      'message',
      "Barang bernama '$nama_barang' telah berhasil ditambahkan!"
    );

    return redirect()->to('/barang-masuk');
  }

  public function hapus(string $id)
  {
    $barang_masuk_model = new BarangMasukModel();
    $stok_model = new StokModel();

    $barang = $barang_masuk_model->find($id);
    $nama_barang = $barang['nama_barang'];
    $builder = $this->db->table('stok');
    $stok = $builder
      ->where('kode_barang', $barang['kode_barang'])
      ->get(1)
      ->getResultArray()[0];
    $stok['total_barang'] =
      (string) ((int) $stok['total_barang'] + (int) $barang['jumlah_masuk']);
    $stok['jumlah_barang_masuk'] =
      (string) ((int) $stok['jumlah_barang_masuk'] - (int) $barang['jumlah_masuk']);

    $barang_masuk_model->delete($id);
    $stok_model->save($stok);

    $this->session->setFlashData(
      'message',
      "Log barang masuk bernama '$nama_barang' telah berhasil dihapus!"
    );

    return redirect()->to('/barang-masuk');
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

    $builder = $this->db->table('barang_masuk');
    $barangData = $builder
      ->orderBy($orderBy ? $orderBy : '', $dir ? $dir : '')
      ->join('supplier', 'supplier.kode_supplier = barang_masuk.kode_supplier')
      ->like('nama_barang', $keyword)
      ->orLike('jumlah_masuk', $keyword)
      ->orLike('nama_supplier', $keyword)
      ->select(
        'id_barang_masuk, nama_barang, nama_supplier, tanggal_masuk, jumlah_masuk'
      )
      ->get($limit, $offset)
      ->getResult();
    $dataSize = sizeof($barangData);
    $allResults = $builder->countAllResults();

    // we need to do this to let gridjs knows the actual count after we
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

  public function export()
  {
    $barangMasukModel = new BarangMasukModel();
    $data = $barangMasukModel->findAll();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // set width
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);

    // set alignment to left
    $spreadsheet
      ->getDefaultStyle()
      ->getAlignment()
      ->setHorizontal(
        \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
      );

    // set styling for header
    $gray_fill = [
      'font' => [
        'bold' => true,
      ],
      'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => ['argb' => 'FFEFEFEF'],
      ],
    ];
    $sheet->getStyle('A1:F1')->applyFromArray($gray_fill);

    $sheet
      ->setCellValue('A1', 'ID Barang Masuk')
      ->setCellValue('B1', 'Kode Barang')
      ->setCellValue('C1', 'Nama Barang')
      ->setCellValue('D1', 'Tanggal Masuk')
      ->setCellValue('E1', 'Jumlah Masuk')
      ->setCellValue('F1', 'Kode Supplier');

    foreach ($data as $k => $v) {
      $i = $k + 2;
      $sheet
        ->setCellValue('A' . $i, $v['id_barang_masuk'])
        ->setCellValue('B' . $i, $v['kode_barang'])
        ->setCellValue('C' . $i, $v['nama_barang'])
        ->setCellValue('D' . $i, $v['tanggal_masuk'])
        ->setCellValue('E' . $i, $v['jumlah_masuk'])
        ->setCellValue('F' . $i, $v['kode_supplier']);
    }

    $writer = new Xlsx($spreadsheet);

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="laporan.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
  }
}
