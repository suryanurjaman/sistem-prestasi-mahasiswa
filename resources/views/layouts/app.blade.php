<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title', 'Aplikasi Saya')</title>
    {{-- Vite akan inject app.css & app.js --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">
    {{-- Navbar --}}
    <nav class="border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/iwu.png') }}" class="h-8" alt="Iwu Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Sistem Informasi Prestasi IWU</span>
            </a>
            <button data-collapse-toggle="navbar-solid-bg" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-solid-bg" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-solid-bg">
                <ul
                    class="flex flex-col font-medium mt-4 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent dark:bg-gray-800 md:dark:bg-transparent dark:border-gray-700">
                    <li>
                        <a href="{{ route('home') }}"
                            class="block py-2 px-3 md:p-0 
                            {{ Request::routeIs('home') ? ' text-white bg-purple-700 rounded-sm md:bg-transparent md:text-purple-700 ' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-purple-700 dark:text-white md:dark:hover:text-purple-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' }}"
                            aria-current="page">Beranda</a>
                    </li>
                    <li>
                        <a href="{{ route('statistik') }}"
                            class="block py-2 px-3 md:p-0 
                            {{ Request::routeIs('statistik') ? ' text-white bg-purple-700 rounded-sm md:bg-transparent md:text-purple-700 ' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-purple-700 dark:text-white md:dark:hover:text-purple-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' }}">Statistik</a>
                    </li>
                    <li>
                        <a href="{{ route('prestasi') }}"
                            class="block py-2 px-3 md:p-0 
                            {{ Request::routeIs('prestasi') ? ' text-white bg-purple-700 rounded-sm md:bg-transparent md:text-purple-700 ' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-purple-700 dark:text-white md:dark:hover:text-purple-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' }}">Prestasi</a>
                    </li>
                    <li>
                        <a href="{{ route('faq') }}"
                            class="block py-2 px-3 md:p-0 
                            {{ Request::routeIs('faq') ? ' text-white bg-purple-700 rounded-sm md:bg-transparent md:text-purple-700 ' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-purple-700 dark:text-white md:dark:hover:text-purple-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' }}">FAQ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten utama --}}
    <main class="container mx-auto px-4 py-8 flex-1">
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- ApexCharts dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Flowbite (jika butuh dropdown toggle) -->
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.bundle.js"></script>
    @stack('scripts')
</body>

</html>
