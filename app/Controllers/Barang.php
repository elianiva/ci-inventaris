<?php

namespace App\Controllers;

use App\Models\Barang as BarangModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Barang extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Master Barang',
      'heading' => 'Barang',
      'page_name' => 'barang',
    ];

    return view('barang/index', $data);
  }

  public function tambah()
  {
    $barangModel = new BarangModel();
    $categories = array_unique($barangModel->findColumn('kategori'));
    $kinds = array_unique($barangModel->findColumn('jenis_barang'));
    $sources = array_unique($barangModel->findColumn('sumber_dana'));

    $data = [
      'title' => 'Master Barang',
      'heading' => 'Barang',
      'page_name' => 'barang',
      'title' => 'Tambah',
      'categories' => $categories,
      'kinds' => $kinds,
      'sources' => $sources,
      'validation' => $this->validator,
    ];

    return view('barang/tambah', $data);
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
        'rules' =>
          'required|is_unique[barang.nama_barang,kode_barang,{kode_barang}]',
      ],
      'spec' => [
        'label' => 'Spesifikasi',
        'rules' => 'required',
      ],
      'address' => [
        'label' => 'Lokasi Barang',
        'rules' => 'required',
      ],
      'category' => [
        'label' => 'Kategori Barang',
        'rules' => 'required',
      ],
      'kind' => [
        'label' => 'Jenis Barang',
        'rules' => 'required',
      ],
      'source' => [
        'label' => 'Sumber Dana',
        'rules' => 'required',
      ],
    ];

    $errors = [
      'name' => [
        'required' => 'Nama Barang tidak boleh kosong!',
        'is_unique' => 'Nama Barang sudah terdaftar',
      ],
      'spec' => [
        'required' => 'Spesifikasi tidak boleh kosong!',
      ],
      'address' => [
        'requied' => 'Lokasi Barang tidak boleh kosong!',
      ],
      'category' => [
        'required' => 'Kategori Barang tidak boleh kosong!',
      ],
      'kind' => [
        'required' => 'Jenis Barang tidak boleh kosong!',
      ],
      'source' => [
        'required' => 'Sumber Dana tidak boleh kosong!',
      ],
    ];

    if (!$this->validate($rules, $errors)) {
      $this->session->setFlashData('errors', $this->validator->getErrors());
      $kode_barang = $request->getVar('kode_barang');
      return redirect()
        ->to('/barang' . $kode_barang ? '/edit/' . $kode_barang : '/tambah')
        ->withInput();
    }

    $barangModel = new BarangModel();
    $nama = $request->getVar('name');

    // this method already handles `insert` and `update`
    // depending on the primary key
    $barangModel->save([
      'kode_barang' => $id ?? \Faker\Factory::create()->ean8(),
      'nama_barang' => $nama,
      'spesifikasi' => $request->getVar('spec'),
      'lokasi_barang' => $request->getVar('address'),
      'kategori' => $request->getVar('category'),
      'kondisi' => $request->getVar('condition'),
      'jenis_barang' => $request->getVar('kind'),
      'sumber_dana' => $request->getVar('source'),
    ]);

    $this->session->setFlashData(
      'message',
      sprintf(
        "Barang bernama '$nama' telah berhasil %s!",
        $id ? 'diperbarui' : 'ditambahkan'
      )
    );

    return redirect()->to('/barang');
  }

  public function hapus(string $id)
  {
    $barangModel = new BarangModel();
    $nama = $barangModel->find($id)['nama_barang'];
    $barangModel->delete($id);

    $this->session->setFlashData(
      'message',
      "Barang bernama '$nama' telah berhasil dihapus!"
    );

    return redirect()->to('/barang');
  }

  public function edit(string $id)
  {
    $barangModel = new BarangModel();
    $categories = array_unique($barangModel->findColumn('kategori'));
    $kinds = array_unique($barangModel->findColumn('jenis_barang'));
    $sources = array_unique($barangModel->findColumn('sumber_dana'));
    $prev = $barangModel->find($id);

    $data = [
      'title' => 'Barang',
      'heading' => 'Barang',
      'page_name' => 'barang',
      'title' => 'Edit',
      'categories' => $categories,
      'kinds' => $kinds,
      'sources' => $sources,
      'prev' => $prev,
      'validation' => $this->validator,
    ];

    return view('barang/tambah', $data);
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

    $builder = $this->db->table('barang');

    $barangData = $builder
      ->orderBy($orderBy ? $orderBy : '', $dir ? $dir : '')
      ->like('nama_barang', $keyword)
      ->orLike('spesifikasi', $keyword)
      ->orLike('lokasi_barang', $keyword)
      ->orLike('jenis_barang', $keyword)
      ->orLike('sumber_dana', $keyword)
      ->orLike('kategori', $keyword)
      ->orLike('kondisi', $keyword)
      ->get($limit, $offset)
      ->getResult();
    $dataSize = sizeof($barangData);
    $allResults = $builder->countAllResults();

    // we need to do this to let gridjs knows the actual count after we
    // do something like `search`
    $barangCount =
      $dataSize == 0 ? 0 : ($keyword == null ? $allResults : $dataSize);

    $response = service('response');
    $response->setHeader('Content-Type', 'application/json');
    $response->setBody(
      json_encode([
        'results' => $barangData,
        'count' => $barangCount,
      ])
    );
    $response->send();
  }

  public function export()
  {
    $barangModel = new BarangModel();
    $data = $barangModel->findAll();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // set width
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    $sheet->getColumnDimension('G')->setAutoSize(true);

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
    $sheet->getStyle('A1:G1')->applyFromArray($gray_fill);

    $sheet
      ->setCellValue('A1', 'Kode Barang')
      ->setCellValue('B1', 'Nama Barang')
      ->setCellValue('C1', 'Spesifikasi Barang')
      ->setCellValue('D1', 'Lokasi Barang')
      ->setCellValue('E1', 'Kategori Barang')
      ->setCellValue('F1', 'Jenis Barang')
      ->setCellValue('G1', 'Sumber Dana');

    foreach ($data as $k => $v) {
      $i = $k + 2;
      $sheet
        ->setCellValue('A' . $i, $v['kode_barang'])
        ->setCellValue('B' . $i, $v['nama_barang'])
        ->setCellValue('B' . $i, $v['spesifikasi'])
        ->setCellValue('C' . $i, $v['lokasi_barang'])
        ->setCellValue('D' . $i, $v['kategori'])
        ->setCellValue('E' . $i, $v['kondisi'])
        ->setCellValue('F' . $i, $v['jenis_barang'])
        ->setCellValue('G' . $i, $v['sumber_dana']);
    }

    $writer = new Xlsx($spreadsheet);

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="laporan.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
  }
}
