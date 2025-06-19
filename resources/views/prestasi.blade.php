@extends('layouts.app')

@section('title', 'Prestasi')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-4">

    <aside id="default-sidebar"
        class="w-full lg:col-span-1" aria-label="Sidebar">
        <div class="h-full px-3 pl-8 py-4 overflow-y-auto">
    
            <form action="{{ route('prestasi') }}" method="GET">
                <ul class="space-y-2 font-medium">
    
                    {{-- Clear Filter --}}
                    <li class="flex justify-between items-center">
                        <p class="text-gray-700">Filter :</p>
                        <a href="{{ route('prestasi') }}" class="text-purple-600 hover:underline cursor-pointer">Clear
                            Filter</a>
                    </li>
    
                    {{-- Search --}}
                    <li>
                        <label for="search"
                            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" name="search" id="search" value="{{ $filters['search'] ?? '' }}"
                                class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500"
                                placeholder="Cari Mahasiswa ..." />
                        </div>
                    </li>
    
                    {{-- Fakultas --}}
                    <li>
                        <label for="fakultas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter
                            Berdasarkan Fakultas</label>
                        <select id="fakultas" name="fakultas"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                            <option value="">Pilih Fakultas</option>
                            @foreach ($fakultasList as $fak)
                                <option value="{{ $fak->id }}"
                                    {{ $filters['fakultas'] == $fak->id ? 'selected' : '' }}>
                                    {{ $fak->nama }}
                                </option>
                            @endforeach
                        </select>
                    </li>
    
                    {{-- Prodi --}}
                    <li>
                        <label for="prodi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Filter Berdasarkan Prodi
                        </label>
                        <select id="prodi" name="prodi"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                            <option value="">Pilih Prodi</option>
                            @foreach ($prodiList as $prd)
                                <option value="{{ $prd->id }}" {{ $filters['prodi'] == $prd->id ? 'selected' : '' }}>
                                    {{ $prd->nama }}
                                </option>
                            @endforeach
                        </select>
                    </li>
                    
                    {{-- Ormawa --}}
                    <li>
                        <label for="ormawa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter
                            Berdasarkan Ormawa</label>
                        <select id="ormawa" name="ormawa"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                            <option value="">Pilih Ormawa</option>
                            @foreach ($ormawaList as $orm)
                                <option value="{{ $orm->id }}" {{ $filters['ormawa'] == $orm->id ? 'selected' : '' }}>
                                    {{ $orm->nama }}
                                </option>
                            @endforeach
                        </select>
                    </li>
    
                    {{-- UKM --}}
                    <li>
                        <label for="ukm" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter
                            Berdasarkan UKM</label>
                        <select id="ukm" name="ukm"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                            <option value="">Pilih UKM</option>
                            @foreach ($ukmList as $ukm)
                                <option value="{{ $ukm->id }}" {{ $filters['ukm'] == $ukm->id ? 'selected' : '' }}>
                                    {{ $ukm->nama }}
                                </option>
                            @endforeach
                        </select>
                    </li>
    
                    {{-- Button Search di bawah semua filter --}}
                    <li>
                        <button type="submit"
                            class="w-full text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2 mt-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                            Search
                        </button>
                    </li>
    
                </ul>
            </form>
    
        </div>
    </aside>
    
    <div class="p-4 lg:col-span-3">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($mahasiswa as $m)
                    <x-prestasi-card :id="$m['id']" :nama="$m['nama']" :nim="$m['nim']" :jurusan="$m['jurusan']"
                        :prodi="$m['prodi']" :totalPrestasi="$m['totalPrestasi']" :poin="$m['poin']" :foto="$m['foto']" />
                @empty
                    <p class="text-center col-span-full text-gray-500">Tidak ada data.</p>
                @endforelse
            </div>
        </div>
    
        @if (
            $mahasiswa instanceof \Illuminate\Pagination\LengthAwarePaginator ||
                $mahasiswa instanceof \Illuminate\Pagination\Paginator)
            <nav aria-label="Page navigation example" class="mt-6 flex justify-end">
                <ul class="inline-flex -space-x-px text-base h-10">
    
                    {{-- Previous Page Link --}}
                    @if ($mahasiswa->onFirstPage())
                        <li>
                            <span
                                class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-400 bg-gray-100 border border-e-0 border-gray-300 rounded-s-lg dark:bg-gray-700 dark:border-gray-700 dark:text-gray-500 cursor-not-allowed">
                                Previous
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $mahasiswa->previousPageUrl() }}"
                                class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                Previous
                            </a>
                        </li>
                    @endif
    
                    {{-- Pagination Elements --}}
                    @foreach ($mahasiswa->links()->elements[0] as $page => $url)
                        @if ($page == $mahasiswa->currentPage())
                            <li>
                                <span
                                    class="flex items-center justify-center px-4 h-10 text-purple-600 border border-gray-300 bg-purple-50 hover:bg-purple-100 hover:text-purple-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                    class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
    
                    {{-- Next Page Link --}}
                    @if ($mahasiswa->hasMorePages())
                        <li>
                            <a href="{{ $mahasiswa->nextPageUrl() }}"
                                class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                Next
                            </a>
                        </li>
                    @else
                        <li>
                            <span
                                class="flex items-center justify-center px-4 h-10 leading-tight text-gray-400 bg-gray-100 border border-gray-300 rounded-e-lg dark:bg-gray-700 dark:border-gray-700 dark:text-gray-500 cursor-not-allowed">
                                Next
                            </span>
                        </li>
                    @endif
    
                </ul>
            </nav>
        @endif
    
    </div>
</div>






@endsection
