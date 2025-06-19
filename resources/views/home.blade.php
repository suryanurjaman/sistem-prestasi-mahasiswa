@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    {{-- hero section --}}
    <section>
        <div class=" grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-8 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h1 class="text-2xl font-semibold mb-6">Selamat datang di</h1>
                <h1
                    class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">
                    Sistem Informasi Prestasi</h1>
                <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                    International Women University</p>
                <a href="{{ url('/mahasiswa/login') }}"
                    class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-purple-900 border border-purple-300 rounded-lg hover:bg-purple-100 focus:ring-4 focus:ring-purple-100 dark:text-white dark:border-purple-700 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                    Ajukan Prestasi
                </a>
            </div>
            <div class="hidden lg:flex lg:justify-end lg:items-center lg:col-span-5 lg:mt-0">
                <img src="{{ asset('images/iwu.png') }}" alt="mockup">
            </div>
        </div>
    </section>


    <section>
        <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
            <div class="max-w-screen-md mb-8 lg:mb-16">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Berikut beberapa data
                    prestasi</h2>
                <p class="text-gray-500 sm:text-xl dark:text-gray-400">Berikut prestasi berdasarkan kategorynya</p>
            </div>
            <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">
                {{-- Fakultas --}}
                <div class="flex justify-center">
                    @include('components.card-prestasi', [
                        'entities' => $fakultasCards,
                        'label' => 'Fakultas',
                    ])
                </div>

                {{-- Prodi --}}
                <div class="flex justify-center">
                    @include('components.card-prestasi', [
                        'entities' => $prodiCards,
                        'label' => 'Program Studi',
                    ])
                </div>

                {{-- Ormawa --}}
                <div class="flex justify-center">
                    @include('components.card-prestasi', [
                        'entities' => $ormawaCards,
                        'label' => 'Organisasi Mahasiswa',
                    ])
                </div>

                {{-- UKM --}}
                <div class="flex justify-center">
                    @include('components.card-prestasi', [
                        'entities' => $ukmCards,
                        'label' => 'Unit Kegiatan Mahasiswa (UKM)',
                    ])
                </div>
            </div>
        </div>
    </section>


    {{-- SECTION GRID 12 saya ingin pake halaman statistik di bagian ini juga gimana caranya --}}
    <section class="py-8 px-4 mx-auto max-w-screen-xl lg:px-6">
        <div class="max-w-screen-md mb-8 lg:mb-16">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Statistik Prestasi</h2>
        </div>
        @include('partials.statistik-section')
    </section>
@endsection

@push('scripts')
    <script>
        const fakultasData = @json($fakultasCounts);
        const prodiData = @json($prodiCounts);
        const ormawaData = @json($ormawaCounts);
        const tahunData = @json($tahunCounts);
        const ukmData = @json($ukmCounts);

        function makeBarChart(ctxId, labels, data, label) {
            const ctx = document.getElementById(ctxId)?.getContext('2d');
            if (!ctx) return;
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: 'rgba(59,130,246,0.7)',
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            makeBarChart('chartFakultas', Object.keys(fakultasData), Object.values(fakultasData),
                'Jumlah Prestasi');
            makeBarChart('chartProdi', Object.keys(prodiData), Object.values(prodiData), 'Jumlah Prestasi');
            makeBarChart('chartOrmawa', Object.keys(ormawaData), Object.values(ormawaData), 'Jumlah Prestasi');
            makeBarChart('chartTahun', Object.keys(tahunData), Object.values(tahunData), 'Jumlah Prestasi');
            makeBarChart('chartUKM', Object.keys(ukmData), Object.values(ukmData), 'Jumlah Prestasi');
        });
    </script>
@endpush
