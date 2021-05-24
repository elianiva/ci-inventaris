<!DOCTYPE html>
<html x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?> | Inventaris SMK</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="<?= base_url() ?>/css/tailwind.output.css" />
    <link rel="stylesheet" href="<?= base_url() ?>/css/custom.css" />
    <link
      href="<?= base_url() ?>/css/mermaid.min.css"
      rel="stylesheet"
    />
    <script
      src="<?= base_url() ?>/js/grid.js"
    ></script>
    <script src="<?= base_url() ?>/js/alpine.min.js"></script>
    <script src="<?= base_url() ?>/js/init-alpine.js"></script>
    <script src="<?= base_url() ?>/js/focus-trap.js"></script>
  </head>
  <body>
    <div
      class="flex h-screen bg-gray-50"
      :class="{ 'overflow-hidden': isSideMenuOpen }"
    >
      <!-- Desktop sidebar -->
      <?= $this->include('layouts/partials/desktop_sidebar') ?>
      <!-- Mobile sidebar -->
      <?= $this->include('layouts/partials/mobile_sidebar') ?>
      <!-- Menu -->
      <?= $this->include('layouts/partials/menu') ?>
    </div>
  </body>
</html>
