<?php

namespace App\Controllers;

use App\Models\Supplier as SupplierModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Supplier extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Supplier',
      'heading' => 'Supplier',
      'page_name' => 'supplier',
    ];

    return view('supplier/index', $data);
  }

  public function form()
  {
    $supplierModel = new SupplierModel();
    $cities = array_unique($supplierModel->findColumn('kota_supplier'));

    $data = [
      'title' => 'Supplier',
      'heading' => 'Supplier',
      'page_name' => 'supplier',
      'title' => 'Tambah',
      'cities' => $cities,
      'validation' => $this->validator,
    ];

    return view('supplier/tambah', $data);
  }

  public function save(string $id = null)
  {
    /**
     * @var \Config\Services::request() $request Incoming request
     */
    $request = $this->request;

    $rules = [
      'name' => [
        'label' => 'Nama Supplier',
        'rules' => $id
          ? 'required'
          : 'required|is_unique[supplier.nama_supplier]',
      ],
      'address' => [
        'label' => 'Alamat Supplier',
        'rules' => $id
          ? 'required'
          : 'required|is_unique[supplier.alamat_supplier]',
      ],
      'telp' => [
        'label' => 'no. Telepon Supplier',
        'rules' => $id
          ? 'required'
          : 'required|is_unique[supplier.telp_supplier]',
      ],
      'city' => [
        'label' => 'Kota Supplier',
        'rules' => 'required',
      ],
    ];

    $errors = [
      'name' => [
        'required' => 'Nama Supplier tidak boleh kosong!',
        'is_unique' => 'Nama Supplier sudah terdaftar!',
      ],
      'address' => [
        'required' => 'Alamat Supplier tidak boleh kosong!',
        'is_unique' => 'Alamat Supplier sudah terdaftar!',
      ],
      'telp' => [
        'required' => 'No. Telepon Supplier tidak boleh kosong!',
        'is_unique' => 'No. Telepon Supplier sudah terdaftar!',
      ],
      'city' => [
        'required' => 'Kota Supplier tidak boleh kosong!',
      ],
    ];

    if (!$this->validate($rules, $errors)) {
      $this->session->setFlashData('errors', $this->validator->getErrors());
      return redirect()
        ->to('/supplier/tambah')
        ->withInput();
    }

    $supplierModel = new SupplierModel();
    $nama = $request->getVar('name');
    $supplierModel->save([
      'kode_supplier' => $id ?? \Faker\Factory::create()->lexify('????'),
      'nama_supplier' => $nama,
      'alamat_supplier' => $request->getVar('address'),
      'telp_supplier' => $request->getVar('telp'),
      'kota_supplier' => $request->getVar('city'),
    ]);

    $this->session->setFlashData(
      'message',
      sprintf(
        "Supplier bernama '$nama' telah berhasil %s!",
        $id ? 'diperbarui' : 'ditambahkan'
      )
    );

    return redirect()->to('/supplier');
  }

  public function hapus(string $id)
  {
    $supplierModel = new SupplierModel();
    $nama = $supplierModel->find($id)['nama_supplier'];
    $supplierModel->delete($id);

    $this->session->setFlashData(
      'message',
      "Supplier bernama '$nama' telah berhasil dihapus!"
    );

    return redirect()->to('/supplier');
  }

  public function edit(string $id)
  {
    $supplierModel = new SupplierModel();
    $cities = array_unique($supplierModel->findColumn('kota_supplier'));
    $prev = $supplierModel->find($id);

    $data = [
      'title' => 'Supplier',
      'heading' => 'Supplier',
      'page_name' => 'supplier',
      'title' => 'Edit',
      'cities' => $cities,
      'validation' => $this->validator,
      'prev' => $prev,
    ];

    return view('supplier/tambah', $data);
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

    $builder = $this->db->table('supplier');

    $supplierData = $builder
      ->orderBy($orderBy ? $orderBy : '', $dir ? $dir : '')
      ->like('nama_supplier', $keyword)
      ->orLike('alamat_supplier', $keyword)
      ->orLike('telp_supplier', $keyword)
      ->orLike('kota_supplier', $keyword)
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
      ])
    );
    $response->send();
  }

  // I really hate the copypasta for this function...
  public function export()
  {
    $supplierModel = new SupplierModel();
    $data = $supplierModel->findAll();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // set width
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);

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
    $sheet->getStyle('A1:E1')->applyFromArray($gray_fill);

    $sheet
      ->setCellValue('A1', 'Kode Supplier')
      ->setCellValue('B1', 'Nama Supplier')
      ->setCellValue('C1', 'Alamat Supplier')
      ->setCellValue('D1', 'Telepon Supplier')
      ->setCellValue('E1', 'Kota Supplier');

    foreach ($data as $k => $v) {
      $i = $k + 2;
      $sheet
        ->setCellValue('A' . $i, $v['kode_supplier'])
        ->setCellValue('B' . $i, $v['nama_supplier'])
        ->setCellValue('C' . $i, $v['alamat_supplier'])
        ->setCellValue('D' . $i, $v['telp_supplier'])
        ->setCellValue('E' . $i, $v['kota_supplier']);
    }

    $writer = new Xlsx($spreadsheet);

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="laporan.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
  }
}
