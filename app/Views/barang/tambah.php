<?= $this->extend('layouts/skeleton') ?>

<?php $err = session()->getFlashData('errors'); ?>

<?= $this->section('content') ?>
<div
  class="container mx-auto px-6 py-6"
>
  <h2
    class="flex justify-between mb-4 text-2xl font-semibold text-gray-600"
  >
    <?= $title ?> Barang
    <a
      class="p-2 block rounded-md border-2 border-orange-500 text-orange-500 font-semibold text-sm"
      href="<?= base_url('/barang/tambah') ?>"
    >
      Kembali
    </a>
  </h2>
  <form
    class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md"
    method="POST"
    action="<?= base_url('/barang/tambah/' . ($prev['kode_barang'] ?? '')) ?>"
  >
    <?= csrf_field() ?>
    <label class="block text-sm">
      <span class="text-gray-700">Nama Barang</span>
      <input
        class="<?= $err['name'] ?? false
          ? 'border-red-500'
          : 'border-gray-200' ?> block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
        name="name"
        id="name-input"
        autocomplete="off"
        value="<?= old('name') ?? ($prev['nama_barang'] ?? '') ?>"
        oninput="resetInput('name-err', 'name-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="name-err">
          <?= $err['name'] ?? '' ?>
        </span>
      <?php endif; ?>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">Spesifikasi</span>
      <input
        class="<?= $err['spec'] ?? false
          ? 'border-red-500'
          : 'border-gray-200' ?> block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
        name="spec"
        id="spec-input"
        autocomplete="off"
        value="<?= old('spec') ?? ($prev['spesifikasi'] ?? '') ?>"
        oninput="resetInput('spec-err', 'spec-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="spec-err">
          <?= $err['spec'] ?? '' ?>
        </span>
      <?php endif; ?>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">Lokasi Barang</span>
      <input
        class="<?= $err['address'] ?? false
          ? 'border-red-500'
          : 'border-gray-200' ?> block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
        name="address"
        id="addr-input"
        autocomplete="off"
        value="<?= old('address') ?? ($prev['lokasi_barang'] ?? '') ?>"
        oninput="resetInput('addr-err', 'addr-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="addr-err">
          <?= $err['address'] ?? '' ?>
        </span>
      <?php endif; ?>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">
        Kategori Barang
      </span>
      <input
        class="<?= $err['telp'] ?? false
          ? 'border-red-500'
          : 'border-gray-200' ?> block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
        type="text"
        list="categories"
        name="category"
        id="category-input"
        value="<?= old('category') ?? ($prev['kategori'] ?? '') ?>"
        oninput="resetInput('category-err', 'category-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="category-err">
          <?= $err['category'] ?? '' ?>
        </span>
      <?php endif; ?>
      <datalist id="categories">
        <?php foreach ($categories as $c): ?>
          <option><?= $c ?></option>
        <?php endforeach; ?>
      </datalist>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">
        Kondisi Barang
      </span>
      <select
        class="block w-full mt-1 text-sm form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue"
        name="condition"
        value="<?= old('condition') ?? ($prev['kondisi'] ?? '') ?>"
      >
        <option value="Baik">Baik</option>
        <option value="Kurang Baik">Kurang Baik</option>
      </select>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">
        Jenis Barang
      </span>
      <input
        class="<?= $err['kinds'] ?? false
          ? 'border-red-500'
          : 'border-gray-200' ?> block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
        type="text"
        list="kinds"
        name="kind"
        id="kind-input"
        value="<?= old('kinds') ?? ($prev['jenis_barang'] ?? '') ?>"
        oninput="resetInput('kind-err', 'kind-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="kind-err">
          <?= $err['kind'] ?? '' ?>
        </span>
      <?php endif; ?>
      <datalist id="kinds">
        <?php foreach ($kinds as $k): ?>
          <option><?= $k ?></option>
        <?php endforeach; ?>
      </datalist>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">
        Sumber Dana
      </span>
      <input
        class="<?= $err['source'] ?? false
          ? 'border-red-500'
          : 'border-gray-200' ?> block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
        type="text"
        list="sources"
        name="source"
        id="source-input"
        value="<?= old('source') ?? ($prev['sumber_dana'] ?? '') ?>"
        oninput="resetInput('source-err', 'source-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="source-err">
          <?= $err['source'] ?? '' ?>
        </span>
      <?php endif; ?>
      <datalist id="sources">
        <?php foreach ($sources as $s): ?>
          <option><?= $s ?></option>
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

<?= $this->endSection('content')
?>
