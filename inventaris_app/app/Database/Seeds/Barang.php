<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Barang extends Seeder
{
  public function run()
  {
    $faker = \Faker\Factory::create('id_ID');
    $faker->seed(1234);

    // fake placeholder data
    $c = ['Alat Tulis Kantor', 'Elektronik', 'Kebersihan', 'Lainnya'];
    $data = [
      ['Kertas HVS Folio 80gram', $c[0]], ['Kertas HVS A4 80gram',    $c[0]],
      ['Amplop Polos',            $c[0]], ['Buku Tulis ABC',          $c[0]],
      ['Kertas Manila Karton',    $c[0]], ['Pensil',                  $c[0]],
      ['Lem',                     $c[0]], ['Karet Penghapus',         $c[0]],
      ['Cover',                   $c[0]], ['Penyekat Buku',           $c[0]],
      ['Tinta Stempel',           $c[0]], ['Gunting',                 $c[0]],
      ['Tali Rafia',              $c[0]], ['Amplop',                  $c[0]],
      ['Kalender',                $c[0]], ['Brosur',                  $c[0]],
      ['Leaflet',                 $c[0]], ['Ballpoint',               $c[0]],
      ['Batu Baterai',            $c[1]], ['Kabel Roll',              $c[1]],
      ['Mesin Fotokopi',          $c[1]], ['Kalkulator',              $c[1]],
      ['Jam Dinding',             $c[1]], ['Printer Dot Matrix',      $c[1]],
      ['Server',                  $c[1]], ['Scanner A4',              $c[1]],
      ['Solder',                  $c[1]], ['Mesin Fax',               $c[1]],
      ['Sabun',                   $c[2]], ['Karbol',                  $c[2]],
      ['Sapu Ijuk',               $c[2]], ['Kemoceng',                $c[2]],
      ['Kamper Bulat',            $c[2]], ['Tisu',                    $c[2]],
      ['Pengharum Ruangan',       $c[2]], ['Sapu Lidi',               $c[2]],
      ['Rak Buku',                $c[3]], ['Tinta Printer',           $c[3]],
      ['Spool Film',              $c[3]], ['Kuas',                    $c[3]],
    ];

    foreach ($data as $d) {
      $data = [
        'kode_barang'   => $faker->uuid(),
        'nama_barang'   => $d[0],
        'spesifikasi'   => $faker->sentence(4),
        'lokasi_barang' => $faker->streetAddress(),
        'kategori'      => $d[1],
        'kondisi'       => $faker->randomElement([
          'Baik',
          'Kurang Baik',
          'Tidak Baik',
        ]),
        'jenis_barang'  => $faker->randomElement([
          'Keperluan Kantor',
          'Lainnya',
        ]),
        'sumber_dana'   => $faker->randomElement([
          'Dana Sekolah',
          'Dana Bansos',
          'Lainnya',
        ]),
        'created_at'    => Time::now(),
        'updated_at'    => Time::now(),
      ];

      $this->db->table('barang')->insert($data);
    }
  }
}
