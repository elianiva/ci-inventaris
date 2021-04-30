<?= $this->extend("layouts/skeleton") ?>

<?= $this->section("content") ?>
<div class="container px-6 mx-auto grid">
  <h2
    class="my-6 text-2xl font-semibold text-gray-700"
  >
    <?= $heading ?>
  </h2>
  <!-- Cards -->
  <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
    <!-- Card -->
    <div
      class="flex items-center p-4 bg-white rounded-lg shadow-xs"
    >
      <div
        class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full"
      >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path
            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
          ></path>
        </svg>
      </div>
      <div>
        <p
          class="mb-2 text-sm font-medium text-gray-600"
        >
          Total Supplier
        </p>
        <p
          class="text-lg font-semibold text-gray-700"
        >
          <?= $total_supplier ?>
        </p>
      </div>
    </div>
    <!-- Card -->
    <div
      class="flex items-center p-4 bg-white rounded-lg shadow-xs"
    >
      <div
        class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full"
      >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path
            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
          ></path>
        </svg>
      </div>
      <div>
        <p
          class="mb-2 text-sm font-medium text-gray-600"
        >
          Total Barang
        </p>
        <p
          class="text-lg font-semibold text-gray-700"
        >
          <?= $total_barang ?>
        </p>
      </div>
    </div>
    <!-- Card -->
    <div
      class="flex items-center p-4 bg-white rounded-lg shadow-xs"
    >
      <div
        class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
        </svg>
      </div>
      <div>
        <p
          class="mb-2 text-sm font-medium text-gray-600"
        >
          Total Barang Masuk
        </p>
        <p
          class="text-lg font-semibold text-gray-700"
        >
          <?= $total_barang_masuk ?>
        </p>
      </div>
    </div>
    <!-- Card -->
    <div
      class="flex items-center p-4 bg-white rounded-lg shadow-xs"
    >
      <div
        class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
        </svg>
      </div>
      <div>
        <p
          class="mb-2 text-sm font-medium text-gray-600"
        >
          Total Barang Keluar
        </p>
        <p
          class="text-lg font-semibold text-gray-700"
        >
          <?= $total_barang_keluar ?>
        </p>
      </div>
    </div>
    <!-- Card -->
    <div
      class="flex items-center p-4 bg-white rounded-lg shadow-xs"
    >
      <div
        class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z" />
          <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z" />
          <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z" />
        </svg>
      </div>
      <div>
        <p
          class="mb-2 text-sm font-medium text-gray-600"
        >
          Total Stok
        </p>
        <p
          class="text-lg font-semibold text-gray-700"
        >
          <?= $total_stok ?>
        </p>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection("content") ?>
