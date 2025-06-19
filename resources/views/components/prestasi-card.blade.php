{{-- resources/views/components/prestasi-card.blade.php --}}
@props(['id', 'nama', 'nim', 'jurusan', 'prodi', 'totalPrestasi', 'poin', 'foto'])

<div
    class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
    {{-- 1) Dropdown --}}
    <div class="flex justify-end p-2">
        <button id="dropdownButton-{{ $id }}" data-dropdown-toggle="dropdown-{{ $id }}"
            class=" text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700
               focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-600 rounded-full p-1"
            type="button">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 16 3">
                <path
                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM8 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
            </svg>
        </button>
        <div id="dropdown-{{ $id }}"
            class="hidden z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                <li><a href="{{ route('prestasi.show', ['id' => $id]) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Detail</a></li>
            </ul>
        </div>
    </div>

    {{-- 2) Foto + Nama/NIM --}}
    <div class="flex items-center space-x-4 px-6 pb-4">
        <img class="w-16 h-16 rounded-full object-cover" src="{{ $foto }}" alt="{{ $nama }}">
        <div>
            <h5 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $nama }}</h5>
            <p class="text-sm text-gray-500 dark:text-gray-400">NIM: {{ $nim }}</p>
        </div>
    </div>

    <hr class="border-gray-200 dark:border-gray-700">

    {{-- 3) Info Jurusan & Prodi --}}
    <div class="grid grid-cols-2 gap-4 px-6 py-4">
        <div>
            <h6 class="text-sm font-medium text-gray-600 dark:text-gray-400">Fakultas</h6>
            <p class="text-sm text-gray-800 dark:text-gray-200">{{ $jurusan }}</p>
        </div>
        <div>
            <h6 class="text-sm font-medium text-gray-600 dark:text-gray-400">Program Studi</h6>
            <p class="text-sm text-gray-800 dark:text-gray-200">{{ $prodi }}</p>
        </div>
    </div>

    <hr class="border-gray-200 dark:border-gray-700">

    {{-- 4) Statistik Prestasi --}}
    <div class="grid grid-cols-2 gap-4 px-6 py-4">
        <div>
            <h6 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Prestasi</h6>
            <p class="text-sm text-gray-800 dark:text-gray-200">{{ $totalPrestasi }}</p>
        </div>
        <div>
            <h6 class="text-sm font-medium text-gray-600 dark:text-gray-400">Poin</h6>
            <p class="text-sm text-gray-800 dark:text-gray-200">{{ $poin }}</p>
        </div>
    </div>
</div>
