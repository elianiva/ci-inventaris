<?= $this->extend("layouts/skeleton") ?>

<?= $this->section("content") ?>
<div
  class="container mx-auto px-6 py-6"
>
  <h2
    class="flex justify-between mb-4 text-2xl font-semibold text-gray-600 dark:text-gray-300"
  >
    Tambah Supplier Baru
    <a
      class="p-2 block rounded-md border-2 border-orange-500 text-orange-500 font-semibold text-sm"
      href="<?= base_url("/supplier") ?>"
    >
      Kembali
    </a>
  </h2>
  <form
    class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
    method="POST"
    action="<?= base_url("/supplier/tambah") ?>"
  >
    <?= csrf_field() ?>
    <label class="block text-sm">
      <span class="text-gray-700 dark:text-gray-400">Nama Supplier</span>
      <input
        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
        name="name"
      />
      <span class="text-xs text-red-600 dark:text-red-400">
        This is a placeholder
      </span>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700 dark:text-gray-400">Alamat Supplier</span>
      <input
        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
        name="address"
      />
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700 dark:text-gray-400">No. Telepon Supplier</span>
      <input
        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
        type="tel"
        name="telp"
      />
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700 dark:text-gray-400">
        Kota Supplier
      </span>
      <input
        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
        type="text"
        list="categories"
        name="city"
      />
      <datalist id="categories">
        <?php foreach($categories as $c): ?>
          <option><?= $c ?></option>
        <?php endforeach; ?>
      </datalist>
    </label>

    <div
      class="flex gap-4 pt-6 pb-2 justify-end"
    >
      <input
        type="submit"
        value="Reset"
        class="px-6 py-2 border-2 border-gray-400 text-gray-600 hover:text-gray-800 font-semibold rounded-md text-sm cursor-pointer"
      />
      <input
        type="submit"
        value="Tambah"
        class="px-6 py-2 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-md text-sm cursor-pointer"
      />
    </div>
  </form>
</div>
<?= $this->endSection("content") ?>
