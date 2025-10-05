<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="mainState" :class="{ 'dark': isDarkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans antialiased">
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">

        <!-- Desktop sidebar -->
        {{-- Pastikan path ini sesuai dengan struktur folder Anda --}}
        @include('layouts.components.sidebar')

        <!-- Mobile sidebar backdrop -->
        <div x-show="isSideMenuOpen"
            class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
            aria-hidden="true">
        </div>

        <!-- Mobile sidebar -->
        <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
            x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
            x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu"
            @keydown.escape="closeSideMenu">
            {{-- Menggunakan konten sidebar yang sama dari file terpisah --}}
            @include('layouts.components.sidebar-content')
        </aside>

        <div class="flex flex-col flex-1 w-full">
            <!-- Navbar -->
            @include('layouts.components.navbar')

            <!-- Page Content -->
            <main class="h-full pb-16 overflow-y-auto">
                <div class="container grid px-6 mx-auto">
                    <!-- Page Heading -->
                    @hasSection('header')
                        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                            @yield('header')
                        </h2>
                    @endif

                    <!-- Main Content -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
