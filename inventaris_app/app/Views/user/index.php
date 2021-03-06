<?= $this->extend('layouts/skeleton') ?>

<?php $session = session(); ?>

<?= $this->section('content') ?>
<div class="container px-6 mx-auto min-w-full">
  <h2
    class="flex justify-between mt-6 mb-2 text-2xl font-semibold text-gray-700"
  >
    <?= $heading ?>
    <a
      class="p-2 block rounded-md bg-green-400 text-white font-semibold text-sm"
      href="<?= base_url('/user/tambah') ?>"
    >
      Tambah User
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
  const action = id => `
  <div class="flex gap-2 mr-4">
    <form action="/user/edit/${id}">
      <button
        class="p-2 bg-blue-500 text-white rounded-md"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
        </svg>
      </button>
    </form>
    <form action="/user/hapus/${id}">
      <button
        class="p-2 bg-red-500 text-white rounded-md"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
      </button>
    </form>
  </div>
  `

  new gridjs.Grid({
    language: {
      search: {
        placeholder: "Cari user..."
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
            "name",
            "username",
          ][col.index]
          const dir = col.direction === 1 ? "ASC" : "DESC";

          return `${prev}?order=${colName}&dir=${dir}&`
        },
      },
    },
    columns: [
      {
        name: "Nama",
        width: "35%",
      },
      {
        name: "Username",
        width: "20%",
      },
      {
        name: "Level",
        width: "15%",
      },
      {
        name: "Aksi",
        width: "10%",
        formatter: (_, row) => gridjs.html(row.cells[3].data),
      }
    ],
    server: {
      url: "<?= base_url('/api/user') ?>",
      then: data => data.results.map(item => [
        item.nama,
        item.username,
        item.level == 1 ? "Admin" : "User",
        action(item.id_user),
      ]),
      total: data => data.count
    }
  }).render(document.getElementById("gridjs-wrapper"))
</script>

<?= $this->endSection('content')
?>
