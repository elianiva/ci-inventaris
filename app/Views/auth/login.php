<?php
$session = session();
$err = $session->getFlashData('errors');
$msg = $session->getFlashData('message');
?>

<!DOCTYPE html>
<html x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Inventaris SMK</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="<?= base_url() ?>/css/tailwind.output.css" />
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="<?= base_url() ?>/js/init-alpine.js"></script>
  </head>
  <body>
    <div class="flex items-center min-h-screen p-6 bg-blue-400">
      <div
        class="flex-1 h-full max-w-xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl"
      >
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="flex items-center justify-center p-6 sm:p-12 w-full">
            <form method="POST" class="w-full" action="<?= base_url(
              '/auth/login',
            ) ?>">
              <?php csrf_field(); ?>
              <h1
                class="mb-6 text-2xl font-semibold text-gray-700 text-center"
              >
                Login
              </h1>
              <?php if ($msg): ?>
                <div
                  class="flex justify-between bg-red-200 px-4 py-2 mx-1 mt-4 mb-2 rounded-md border-2 border-red-400 text-red-700 font-semibold"
                  id="flash-msg"
                >
                  <?= $msg ?>
                  <button
                    class="text-md font-semibold"
                    onclick="document.getElementById('flash-msg').remove()"
                  >
                    ✕
                  </button>
                </div>
              <?php endif; ?>
              <label class="block text-sm">
                <span class="text-gray-700">Username</span>
                <input
                  class="block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
                  placeholder="Jane Doe"
                  name="username"
                />
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-70 ">Password</span>
                <input
                  class="block w-full mt-1 text-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
                  placeholder="***************"
                  type="password"
                  name="password"
                />
              </label>

              <!-- You should use a button here, as the anchor is only used for the example  -->
              <input
                class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue"
                type="submit"
                value="Log In"
              />
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
