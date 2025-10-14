<nav class="py-4 text-gray-500 dark:text-gray-400">
    {{-- Logo --}}
    <a href="{{ route('dashboard') }}" class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center">
        <svg class="w-8 h-8 me-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
                d="M4 4h4v4H4zM4 10h4v4H4zM4 16h4v4H4zM10 4h4v4h-4zM10 10h4v4h-4zM10 16h4v4h-4zM16 4h4v4h-4zM16 10h4v4h-4zM16 16h4v4h-4z" />
        </svg>
        <span>HRIS GABUT</span>
    </a>

    <ul class="mt-4 ms-1">
        {{-- Dashboard --}}
        <li class="relative px-6 py-3">
            <a href="{{ auth()->user()->role === 'admin' ? route('hr.dashboard') : route('dashboard') }}"
                @class([
                    'inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200',
                    'text-blue-600 dark:text-blue-300' => request()->routeIs(
                        auth()->user()->role === 'admin' ? 'hr.dashboard' : 'dashboard'),
                ])>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h4v4H4zM14 6h4v4h-4zM4 16h4v4H4zM14 16h4v4h-4zM10 6h4v4h-4zM10 16h4v4h-4z" />
                </svg>
                <span class="ml-4">Dashboard</span>
            </a>
        </li>

        {{-- Admin Menu --}}
        @if (auth()->user()->role === 'admin')
            @php
                $isHrMenuActive = request()->routeIs('employees.*', 'departments.*');
                $isAttendanceMenuActive = request()->routeIs('attendances.*');
            @endphp

            {{-- HR Management --}}
            <li class="relative px-6 py-3" x-data="{ isOpen: {{ $isHrMenuActive ? 'true' : 'false' }} }">
                <button @click="isOpen = !isOpen" @class([
                    'inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200',
                    'text-blue-600 dark:text-blue-300' => $isHrMenuActive,
                ])>
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M10 15H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <circle cx="18" cy="15" r="3" />
                            <path d="m19.5 12.5.5-1" />
                            <path d="m19.5 17.5.5 1" />
                            <path d="m21 15h1" />
                            <path d="m15 15h1" />
                            <path d="m16.5 12.5-.5-1" />
                            <path d="m16.5 17.5-.5 1" />
                        </svg>
                        <span class="ml-4">HR Management</span>
                    </span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': isOpen }"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.3 7.3a1 1 0 011.4 0L10 10.6l3.3-3.3a1 1 0 111.4 1.4l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <ul x-show="isOpen" x-collapse class="p-2 ms-5 space-y-2 text-sm font-medium text-gray-500 rounded-md">
                    @foreach ([['route' => 'departments.index', 'label' => 'Departments'], ['route' => 'employees.index', 'label' => 'Employee Lists']] as $item)
                        <li>
                            <a href="{{ route($item['route']) }}" @class([
                                'block px-3 py-2 rounded-md transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200',
                                'text-blue-600 bg-blue-100 dark:text-blue-200 dark:bg-blue-900' => request()->routeIs(
                                    Str::before($item['route'], '.') . '.*'),
                            ])>
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>

            {{-- Attendance --}}
            <li class="relative px-6 py-3" x-data="{ isOpen: {{ $isAttendanceMenuActive ? 'true' : 'false' }} }">
                <button @click="isOpen = !isOpen" @class([
                    'inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200',
                    'text-blue-600 dark:text-blue-300' => $isAttendanceMenuActive,
                ])>
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M13 5h8" />
                            <path d="M13 12h8" />
                            <path d="M13 19h8" />
                            <path d="m3 17 2 2 4-4" />
                            <path d="m3 7 2 2 4-4" />
                        </svg>
                        <span class="ml-4">Attendance</span>
                    </span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': isOpen }"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.3 7.3a1 1 0 011.4 0L10 10.6l3.3-3.3a1 1 0 111.4 1.4l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <ul x-show="isOpen" x-collapse class="p-2 ms-5 space-y-2 text-sm font-medium text-gray-500 rounded-md">
                    @foreach ([['route' => 'employees.index', 'label' => 'Attendance (HR)'], ['route' => 'attendances.index', 'label' => 'Monitoring']] as $item)
                        <li>
                            <a href="{{ route($item['route']) }}" @class([
                                'block px-3 py-2 rounded-md transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200',
                                'text-blue-600 bg-blue-100 dark:text-blue-200 dark:bg-blue-900' => request()->routeIs(
                                    $item['route']),
                            ])>
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif
    </ul>
</nav>
