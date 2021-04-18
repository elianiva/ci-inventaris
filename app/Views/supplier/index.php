<?= $this->extend("layouts/skeleton") ?>

<?= $this->section("content") ?>
<div class="container px-4 pb-4">
  <h2
    class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
  >
    <?= $heading ?>
  </h2>
  <div id="gridjs-wrapper"></div>
</div>

<script>
  const isContinuable = (url) => url.split('')[url.length-1] === "&"
  const grid = new gridjs.Grid({
    language: {
      search: {
        placeholder: "Cari supplier..."
      },
    },
    pagination: {
      enabled: true,
      limit: 10,
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
            "nama_supplier",
            "alamat_supplier",
            "telp_supplier",
            "kota_supplier",
          ][col.index]
          const dir = col.direction === 1 ? "ASC" : "DESC";

          return `${prev}?order=${colName}&dir=${dir}&`
        },
      },
    },
    columns: [
      "Nama Supplier", "Alamat Supplier", "Telp. Supplier", "Kota Supplier"
    ],
    server: {
      url: "<?= base_url("/api/supplier") ?>",
      then: data => data.results.map(item => [
        item.nama_supplier,
        item.alamat_supplier,
        item.telp_supplier,
        item.kota_supplier,
      ]),
      total: data => data.count
    }
  });
  grid.render(document.getElementById("gridjs-wrapper"))
</script>

<?= $this->endSection("content") ?>
