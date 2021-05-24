<?= $this->extend('layouts/skeleton') ?>

<?php $session = session() ?>

<?= $this->section('content') ?>
<div class="container px-6 mx-auto min-w-full">
  <h2
    class="flex justify-between mt-6 mb-2 text-2xl font-semibold text-gray-700"
  >
    <?= $heading ?>
    <a
      class="p-2 block rounded-md bg-blue-400 hover:bg-blue-500 text-white font-semibold text-sm"
      href="<?= base_url('/barang/export') ?>"
    >
      Cetak Laporan
    </a>
  </h2>
  <?php if ($session->getFlashData('message')): ?>
    <div
      class="flex justify-between bg-green-200 px-4 py-2 mx-1 mt-4 mb-2 rounded-md border-2 border-green-400 text-green-700 font-semibold"
      id="flash-msg"
    >
        <?= $session->getFlashData('message') ?>
      <button
        class="text-md font-semibold"
        onclick="document.getElementById('flash-msg').remove()"
      >
        ✕
      </button>
    </div>
  <?php endif; ?>
  <div id="gridjs-wrapper"></div>
</div>

<script>
  const isContinuable = (url) => url.split('')[url.length-1] === "&"

  new gridjs.Grid({
    language: {
      search: {
        placeholder: "Cari barang..."
      },
    },
    pagination: {
      enabled: true,
      limit: 5,
      summary: true,
      server: {
        url: (prev, page, limit) => {
          return isContinuable(prev)
           ? `${prev}limit=${limit}&offset=${page * limit}&`
           : `${prev}?limit=${limit}&offset=${page * limit}&`
        }
      },
    },
    search: {
      server: {
        url: (prev, keyword) => {
          return isContinuable(prev)
            ? `${prev}search=${keyword}&`
            : `${prev}?search=${keyword}&`
        }
      },
    },
    sort: {
      multiColumn: false,
      server: {
        url: (prev, cols) => {
          if (!cols.length) return prev;

          let col = cols[0]
          let colName = [
            "nama_barang",
            "tanggal_masuk",
            "jumlah_masuk",
            "nama_supplier",
          ][col.index]
          const dir = col.direction === 1 ? "ASC" : "DESC";

          return `${prev}?order=${colName}&dir=${dir}&`
        },
      },
    },
    columns: [
      { name: "Nama Barang" },
      { name: "Jumlah Masuk" },
      { name: "Jumlah Keluar" },
      { name: "Total Barang" },
    ],
    server: {
      url: "<?= base_url('/api/stok') ?>",
      // then: data => console.log(data),
      then: data => data.results.map(item => [
        item.nama_barang,
        item.jumlah_barang_masuk,
        item.jumlah_barang_keluar,
        item.total_barang,
      ]),
      total: data => data.count
    }
  }).render(document.getElementById("gridjs-wrapper"))
</script>

<?= $this->endSection('content')
?>
