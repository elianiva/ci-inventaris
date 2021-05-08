<?= $this->extend('layouts/skeleton') ?>

<?php $err = session()->getFlashData('errors'); ?>

<?= $this->section('content') ?>
<div
  class="container mx-auto px-6 py-6"
>
  <h2
    class="flex justify-between mb-4 text-2xl font-semibold text-gray-600"
  >
    <?= $title ?> User
    <a
      class="p-2 block rounded-md border-2 border-orange-500 text-orange-500 font-semibold text-sm"
      href="<?= base_url('/user') ?>"
    >
      Kembali
    </a>
  </h2>
  <form
    class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md"
    method="POST"
    action="<?= base_url('/user/tambah/' . ($prev['id_user'] ?? '')) ?>"
  >
    <input
      type="hidden"
      name="id_user"
      value="<?= $prev['id_user'] ?? '' ?>"
    />
    <?= csrf_field() ?>
    <label class="block text-sm">
      <span class="text-gray-700">Nama</span>
      <input
        class="<?= $err['name'] ?? false
          ? 'border-red-500'
          : 'border-gray-200' ?> block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
        name="name"
        id="name-input"
        autocomplete="off"
        value="<?= old('nama') ?? ($prev['nama'] ?? '') ?>"
        oninput="resetInput('name-err', 'name-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="name-err">
          <?= $err['name'] ?? '' ?>
        </span>
      <?php endif; ?>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">Username</span>
      <input
        class="<?= $err['username'] ?? false
          ? 'border-red-500'
          : 'border-gray-200' ?> block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
        name="username"
        id="username-input"
        autocomplete="off"
        value="<?= old('username') ?? ($prev['username'] ?? '') ?>"
        oninput="resetInput('username-err', 'username-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="username-err">
          <?= $err['username'] ?? '' ?>
        </span>
      <?php endif; ?>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">Password</span>
      <input
        class="<?= $err['password'] ?? false
          ? 'border-red-500'
          : 'border-gray-200' ?> block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
        name="password"
        id="password-input"
        autocomplete="off"
        type="password"
        oninput="resetInput('password-err', 'password-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="password-err">
          <?= $err['password'] ?? '' ?>
        </span>
      <?php endif; ?>
    </label>

    <label class="block mt-4 text-sm">
      <span class="text-gray-700">Ulangi Password</span>
      <input
        class="<?= $err['password'] ?? false
          ? 'border-red-500'
          : 'border-gray-200' ?> block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
        name="password-rep"
        id="password-rep-input"
        autocomplete="off"
        type="password"
        oninput="resetInput('password-rep-err', 'password-rep-input')"
      />
      <?php if ($err): ?>
        <span class="text-xs text-red-600" id="password-rep-err">
          <?= $err['password-rep'] ?? '' ?>
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

<?= $this->endSection('content')
?>
