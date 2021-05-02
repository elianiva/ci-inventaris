<?= $this->extend('layouts/skeleton') ?>

<?php $err = session()->getFlashData('errors'); ?>

<?= $this->section('content') ?>
<div
  class="container mx-auto px-6 py-6"
>
  <h2
    class="flex justify-between mb-4 text-2xl font-semibold text-gray-600"
  >
    <?= $title ?> Barang Keluar
    <a
      class="p-2 block rounded-md border-2 border-orange-500 text-orange-500 font-semibold text-sm"
      href="<?= base_url('/barang-keluar') ?>"
    >
      Kembali
    </a>
  </h2>
  <form
    class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md"
    method="POST"
    action="<?= base_url('/barang-keluar/tambah/' . ($prev['kode_barang'] ?? '')) ?>"
  >
    <?= csrf_field() ?>
    <label class="block mt-4 text-sm">
      <span class="text-gray-700">Nama Barang</span>
      <select
        class="block w-full mt-1 text-sm form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue"
        name="name"
        value="<?= old('name') ?? ($prev['nama_barang'] ?? '') ?>"
      >
        <?php foreach ($barang as $b): ?>
          <option value="<?= $b ?>"><?= $b ?></option>
        <?php endforeach; ?>
      </select>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">Tanggal keluar</span>
      <input
        class="<?= $err['date'] ?? false
          ? 'border-red-500'
          : 'border-gray-200' ?> block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
        name="date"
        id="date"
        autocomplete="off"
        type="date"
        value="<?= old('date') ?? ($prev['tanggal_keluar'] ?? '') ?>"
        oninput="resetInput('date-err', 'date-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="date-err">
          <?= $err['date'] ?? '' ?>
        </span>
      <?php endif; ?>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">Nama Supplier</span>
      <select
        class="block w-full mt-1 text-sm form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue"
        name="supplier"
        value="<?= old('supplier') ?? ($prev['nama_supplier'] ?? '') ?>"
      >
        <?php foreach ($supplier as $s): ?>
          <option value="<?= $s ?>"><?= $s ?></option>
        <?php endforeach; ?>
      </select>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">Jumlah Barang</span>
      <input
        class="<?= $err['total'] ?? false
          ? 'border-red-500'
          : 'border-gray-200' ?> block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
        name="total"
        id="total"
        autocomplete="off"
        type="number"
        value="<?= old('total') ?? ($prev['jumlah_keluar'] ?? '') ?>"
        oninput="resetInput('total-err', 'total-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="total-err">
          <?= $err['total'] ?? '' ?>
        </span>
      <?php endif; ?>
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
        value="<?= $title ?>"
        class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md text-sm cursor-pointer"
      />
    </div>
  </form>
</div>

<script>
// reset the input
// seems hacky tho..
const resetInput = (textID, inputID) => {
  document.getElementById(textID)?.remove()
  document.getElementById(inputID).classList.remove("border-red-500")
  document.getElementById(inputID).classList.add("border-gray-200")
}
</script>

<?= $this->endSection('content') ?>
