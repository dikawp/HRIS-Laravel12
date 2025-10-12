<nav class="py-4 text-gray-500 dark:text-gray-400">
    {{-- Logo --}}
    <a href="{{ route('dashboard') }}" class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center">
        <svg class="w-8 h-8 me-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
                d="M4 4h4v4H4zM4 10h4v4H4zM4 16h4v4H4zM10 4h4v4h-4zM10 10h4v4h-4zM10 16h4v4h-4zM16 4h4v4h-4zM16 10h4v4h-4zM16 16h4v4h-4z">
            </path>
        </svg>
        <span>HRIS GABUT</span>
    </a>

    <ul class="mt-4 ms-1">
        <li class="relative px-6 py-3">
            @if (auth()->user()->role == 'admin')
                {{-- Admin --}}
                <a href="{{ route('hr.dashboard') }}"
                    class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('hr.dashboard') ? 'text-blue-600 dark:text-blue-300' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="ml-4">Dashboard</span>
                </a>
            @elseif(auth()->user()->role == 'user')
                {{-- User --}}
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-300' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="ml-4">Dashboard</span>
                </a>
            @endif
        </li>

        @if (auth()->user()->role == 'admin')
            @php
                $isHrMenuActive = request()->routeIs('employees.*') || request()->routeIs('departments.*');
            @endphp

            <li class="relative px-6 py-3" x-data="{ isMenuOpen: {{ $isHrMenuActive ? 'true' : 'false' }} }">
                <button @click="isMenuOpen = !isMenuOpen"
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ $isHrMenuActive ? 'text-blue-600 dark:text-blue-300' : '' }}">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-user-cog-icon lucide-user-cog">
                            <path d="M10 15H6a4 4 0 0 0-4 4v2" />
                            <path d="m14.305 16.53.923-.382" />
                            <path d="m15.228 13.852-.923-.383" />
                            <path d="m16.852 12.228-.383-.923" />
                            <path d="m16.852 17.772-.383.924" />
                            <path d="m19.148 12.228.383-.923" />
                            <path d="m19.53 18.696-.382-.924" />
                            <path d="m20.772 13.852.924-.383" />
                            <path d="m20.772 16.148.924.383" />
                            <circle cx="18" cy="15" r="3" />
                            <circle cx="9" cy="7" r="4" />
                        </svg>
                        <span class="ml-4">HR Management</span>
                    </span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': isMenuOpen }"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>

                <ul id="dashboard-submenu" x-show="isMenuOpen" x-collapse
                    class="p-2 ms-5 space-y-2 text-sm font-medium text-gray-500 rounded-md">
                    <li>
                        <a href="{{ route('departments.index') }}"
                            class="block px-3 py-2 rounded-md transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('departments.*') ? 'text-blue-600 bg-blue-100 dark:text-blue-200 dark:bg-blue-900' : '' }}">
                            Departments
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employees.index') }}"
                            class="block px-3 py-2 rounded-md transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('employees.*') ? 'text-blue-600 bg-blue-100 dark:text-blue-200 dark:bg-blue-900' : '' }}">
                            Employee Lists
                        </a>
                    </li>
                </ul>
            </li>

            <li class="relative px-6 py-3" x-data="{ isMenuOpen: {{ $isHrMenuActive ? 'true' : 'false' }} }">
                <button @click="isMenuOpen = !isMenuOpen"
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-list-checks-icon lucide-list-checks">
                            <path d="M13 5h8" />
                            <path d="M13 12h8" />
                            <path d="M13 19h8" />
                            <path d="m3 17 2 2 4-4" />
                            <path d="m3 7 2 2 4-4" />
                        </svg>
                        <span class="ml-4">Attendance</span>
                    </span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': isMenuOpen }"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>

                <ul id="dashboard-submenu" x-show="isMenuOpen" x-collapse
                    class="p-2 ms-5 space-y-2 text-sm font-medium text-gray-500 rounded-md">
                    <li>
                        <a href="{{ route('departments.index') }}"
                            class="block px-3 py-2 rounded-md transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            Attendance (HR)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('departments.index') }}"
                            class="block px-3 py-2 rounded-md transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            Main Attendance
                        </a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</nav>
