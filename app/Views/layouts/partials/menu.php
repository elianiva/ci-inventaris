<div class="flex flex-col flex-1 w-full main-content">
  <header class="z-10 py-4 bg-white shadow-md">
    <div
      class="container flex items-center justify-between h-full px-6 mx-auto text-blue-600"
    >
      <!-- Mobile hamburger -->
      <button
        class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-blue"
        @click="toggleSideMenu"
        aria-label="Menu"
      >
        <svg
          class="w-6 h-6"
          aria-hidden="true"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            fill-rule="evenodd"
            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
            clip-rule="evenodd"
          ></path>
        </svg>
      </button>
      <!-- spacing -->
      <div class="flex-1"></div>
      <ul class="flex items-center flex-shrink-0 space-x-6">
        <span class="text-gray-600 font-semibold text-lg">
          Halo, <?= session()->current_user['username'] ?>!
        </span>
        <!-- Profile menu -->
        <li class="relative">
          <button
            class="align-middle rounded-full focus:shadow-outline-blue focus:outline-none"
            @click="toggleProfileMenu"
            @keydown.escape="closeProfileMenu"
            aria-label="Account"
            aria-haspopup="true"
          >
            <img
              class="object-cover w-8 h-8 rounded-full"
              src="<?= base_url() ?>/img/user.png"
              alt="profile picture"
              aria-hidden="true"
            />
          </button>
          <template x-if="isProfileMenuOpen">
            <ul
              x-transition:leave="transition ease-in duration-100"
              x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0"
              @click.away="closeProfileMenu"
              @keydown.escape="closeProfileMenu"
              class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md"
              aria-label="submenu"
            >
              <li class="flex ">
                <form action="<?= base_url('/auth/logout') ?>">
                  <button
                    class="hover:bg-gray-100 inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md"
                    type="submit"
                  >
                    <svg
                      class="w-4 h-4 mr-3"
                      aria-hidden="true"
                      fill="none"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
                      ></path>
                    </svg>
                    <span>Log Out</span>
                  </button>
                </form>
              </li>
            </ul>
          </template>
        </li>
      </ul>
    </div>
  </header>
  <main class="h-full overflow-y-auto" >
    <?= $this->renderSection('content') ?>
  </main>
</div>
