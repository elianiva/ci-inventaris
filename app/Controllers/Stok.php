<?php

namespace App\Controllers;

use App\Models\Stok as StokModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Stok extends BaseController
{
  public function index()
  {
    $data = [
      'title'     => 'Stok',
      'heading'   => 'Stok',
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

    // we need to do this to let gridjs knows the actual count after we
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

  public function export()
  {
    $supplierModel = new StokModel();
    $data = $supplierModel->findAll();

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
      ->setCellValue('A1', 'Kode Barang')
      ->setCellValue('B1', 'Nama Barang')
      ->setCellValue('C1', 'Jumlah Barang Masuk')
      ->setCellValue('D1', 'Jumlah Barang Keluar')
      ->setCellValue('E1', 'Total Barang')
      ->setCellValue('F1', 'Keterangan');

    foreach ($data as $k => $v) {
      $i = $k + 2;
      $sheet
        ->setCellValue('A' . $i, $v['kode_barang'])
        ->setCellValue('B' . $i, $v['nama_barang'])
        ->setCellValue('C' . $i, $v['jumlah_barang_masuk'])
        ->setCellValue('D' . $i, $v['jumlah_barang_masuk'])
        ->setCellValue('E' . $i, $v['total_barang'])
        ->setCellValue('F' . $i, $v['keterangan']);
    }

    $writer = new Xlsx($spreadsheet);

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="laporan.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
  }
}
