<?= $this->extend("layouts/skeleton") ?>

<?php $err = session()->getFlashData("errors"); ?>

<?= $this->section("content") ?>
<div
  class="container mx-auto px-6 py-6"
>
  <h2
    class="flex justify-between mb-4 text-2xl font-semibold text-gray-600"
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
    class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md"
    method="POST"
    action="<?= base_url("/supplier/tambah") ?>"
  >
    <?= csrf_field() ?>
    <label class="block text-sm">
      <span class="text-gray-700">Nama Supplier</span>
      <input
        class="<?= $err["name"] ?? false
          ? "border-red-500"
          : "border-gray-200" ?> block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
        name="name"
        id="name-input"
        autocomplete="off"
        value="<?= old("name") ?>"
        oninput="resetInput('name-err', 'name-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="name-err">
          <?= $err["name"] ?? "" ?>
        </span>
      <?php endif; ?>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">Alamat Supplier</span>
      <input
        class="<?= $err["address"] ?? false
          ? "border-red-500"
          : "border-gray-200" ?> block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
        name="address"
        id="addr-input"
        autocomplete="off"
        value="<?= old("address") ?>"
        oninput="resetInput('addr-err', 'addr-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="addr-err">
          <?= $err["address"] ?? "" ?>
        </span>
      <?php endif; ?>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">No. Telepon Supplier</span>
      <input
        class="<?= $err["telp"] ?? false
          ? "border-red-500"
          : "border-gray-200" ?> block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
        type="tel"
        name="telp"
        id="telp-input"
        autocomplete="off"
        value="<?= old("telp") ?>"
        oninput="resetInput('telp-err', 'telp-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="telp-err">
          <?= $err["telp"] ?? "" ?>
        </span>
      <?php endif; ?>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">
        Kota Supplier
      </span>
      <input
        class="<?= $err["telp"] ?? false
          ? "border-red-500"
          : "border-gray-200" ?> block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
        type="text"
        list="cities"
        name="city"
        id="city-input"
        oninput="resetInput('city-err', 'city-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="city-err">
          <?= $err["city"] ?? "" ?>
        </span>
      <?php endif; ?>
      <datalist id="cities">
        <?php foreach ($cities as $c): ?>
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

<script>
// reset the input
// seems hacky tho..
const resetInput = (textID, inputID) => {
  document.getElementById(textID)?.remove()
  document.getElementById(inputID).classList.remove("border-red-500")
  document.getElementById(inputID).classList.add("border-gray-200")
}
</script>

<?= $this->endSection("content") ?>
