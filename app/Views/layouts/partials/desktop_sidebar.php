<aside
  class="z-20 hidden w-64 overflow-y-auto bg-white md:block flex-shrink-0"
>
  <div class="py-4 text-gray-500">
    <a
      class="ml-6 text-lg font-bold text-gray-800"
      href="<?= base_url('/') ?>"
    >
      Inventaris SMK
    </a>
    <ul class="mt-6">
      <li class="relative px-6 py-3">
        <span
          class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg <?= $page_name ==
          'dashboard'
            ? 'visible'
            : 'hidden' ?>"
          aria-hidden="true"
        ></span>
        <a
          class="inline-flex items-center w-full text-sm font-semibold <?= $page_name ==
          'dashboard'
            ? 'text-gray-800'
            : 'text-gray-500' ?> transition-colors duration-150 hover:text-gray-800"
          href="<?= base_url('/dashboard') ?>"
        >
          <svg
            class="w-5 h-5"
            aria-hidden="true"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
            ></path>
          </svg>
          <span class="ml-4">Dashboard</span>
        </a>
      </li>
      <?php if (session()->current_user['level'] == 1): ?>
        <li class="relative px-6 py-3">
          <span
            class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg <?= $page_name ==
            'user'
              ? 'visible'
              : 'hidden' ?>"
            aria-hidden="true"
          ></span>
          <a
            class="inline-flex items-center w-full text-sm font-semibold <?= $page_name ==
            'user'
              ? 'text-gray-800'
              : 'text-gray-500' ?> transition-colors duration-150 hover:text-gray-800"
            href="<?= base_url('/user') ?>"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="ml-4">User</span>
          </a>
        </li>
      <?php endif; ?>
      <li class="relative px-6 py-3">
        <span
          class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg <?= $page_name ==
          'stok'
            ? 'visible'
            : 'hidden' ?>"
          aria-hidden="true"
        ></span>
        <a
          class="inline-flex items-center w-full text-sm font-semibold <?= $page_name ==
          'stok'
            ? 'text-gray-800'
            : 'text-gray-500' ?> transition-colors duration-150 hover:text-gray-800"
          href="<?= base_url('/stok') ?>"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
          </svg>
          <span class="ml-4">Stok</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span
          class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg <?= $page_name ==
          'supplier'
            ? 'visible'
            : 'hidden' ?>"
          aria-hidden="true"
        ></span>
        <a
          class="inline-flex items-center w-full text-sm font-semibold <?= $page_name ==
          'supplier'
            ? 'text-gray-800'
            : 'text-gray-500' ?> transition-colors duration-150 hover:text-gray-800"
          href="<?= base_url('/supplier') ?>"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <span class="ml-4">Supplier</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span
          class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg <?= $page_name ==
          'barang'
            ? 'visible'
            : 'hidden' ?>"
          aria-hidden="true"
        ></span>
        <button
          class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800"
          @click="togglePagesMenu"
          aria-haspopup="true"
        >
          <span class="inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
            <span class="ml-4">Barang</span>
          </span>
          <svg
            class="w-4 h-4"
            aria-hidden="true"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path
              fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"
            ></path>
          </svg>
        </button>
        <template x-if="isPagesMenuOpen">
          <ul
            x-transition:enter="transition-all ease-in-out duration-300"
            x-transition:enter-start="opacity-25 max-h-0"
            x-transition:enter-end="opacity-100 max-h-xl"
            x-transition:leave="transition-all ease-in-out duration-300"
            x-transition:leave-start="opacity-100 max-h-xl"
            x-transition:leave-end="opacity-0 max-h-0"
            class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50"
            aria-label="submenu"
          >
            <li
              class="px-2 py-1 transition-colors duration-150 hover:text-gray-800"
            >
              <a
                class="w-full"
              href="<?= base_url('/barang') ?>"
              >
                Master Barang
              </a>
            </li>
            <li
              class="px-2 py-1 transition-colors duration-150 hover:text-gray-800"
            >
              <a
                class="w-full"
                href="<?= base_url('/barang-masuk') ?>"
              >
                Barang Masuk
              </a>
            </li>
            <li
              class="px-2 py-1 transition-colors duration-150 hover:text-gray-800"
            >
              <a
                class="w-full"
                href="<?= base_url('/barang-keluar') ?>"
              >
                Barang Keluar
              </a>
            </li>
          </ul>
        </template>
      </li>
    </ul>
  </div>
</aside>
