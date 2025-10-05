<nav class="py-4 text-gray-500 dark:text-gray-400">
    {{-- Logo --}}
    <a href="{{ route('dashboard') }}" class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center">
        <svg class="w-8 h-8 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
                d="M4 4h4v4H4zM4 10h4v4H4zM4 16h4v4H4zM10 4h4v4h-4zM10 10h4v4h-4zM10 16h4v4h-4zM16 4h4v4h-4zM16 10h4v4h-4zM16 16h4v4h-4z">
            </path>
        </svg>
        <span>HRIS GABUT</span>
    </a>

    <ul class="mt-4">
        <li class="relative px-6 py-3">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-300' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                <span class="ml-4">Dashboard</span>
            </a>
        </li>

        <li class="relative px-6 py-3" x-data="{ isMenuOpen: false }" :class="{ 'font-semibold': isMenuOpen }">
            <button @click="isMenuOpen = !isMenuOpen" aria-expanded="isMenuOpen" aria-controls="dashboard-submenu"
                class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <span class="inline-flex items-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="ml-4">HR Menu</span>
                </span>
                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': isMenuOpen }"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>

            <ul id="dashboard-submenu" x-show="isMenuOpen" x-collapse
                class="p-2 mt-2 space-y-4 text-sm font-medium text-gray-500 rounded-md shadow-inner">
                <li>
                    <a href="#"
                        class="block px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                        Departement Lists
                    </a>
                </li>
                <li>
                    <a href="{{ route('employees.index') }}"
                        class="block px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                        Employee Lists
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
