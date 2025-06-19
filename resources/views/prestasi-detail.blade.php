@extends('layouts.app')

@section('title', 'Detail Prestasi Mahasiswa')

@section('content')
    <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
        <div class="flex justify-between mb-4">
            <button type="button" onclick="window.history.back()"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>


                <span class="sr-only">Tombol back</span>
            </button>

            <button type="button" id="download-img-btn"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Download CV
            </button>
        </div>


        {{-- ini bagian yang ingin saya download sebagai CV --}}

        <div class="flex justify-center content-center">
            <div class="border border-gray-300 rounded-sm shadow-lg py-10 px-10 w-full mt-10 mb-10">
                <div id="cv-to-print" class="py-10 px-10 w-full mt-10 mb-10">
                    <header class="pb-6 border-b border-gray-200 mb-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="bg-cover bg-no-repeat bg-cyan-100 rounded-full h-52 w-52"
                                    style="background-image: url('{{ $mahasiswa->foto_mahasiswa
                                        ? asset('storage/' . $mahasiswa->foto_mahasiswa)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($mahasiswa->user->name) }}')">
                                </div>
                            </div>
                            <div class="grid justify-items-end">
                                <h1 class="text-7xl font-extrabold mb-2">{{ $mahasiswa->user->name }}</h1>
                                <div class="flex flex-row gap-4 items-end">
                                    <p class="text-xl mt-5">{{ $mahasiswa->prodi->nama }}</p>
                                    <span class="text-xl mt-5">|</span>
                                    <p class="text-xl mt-5">{{ $mahasiswa->fakultas->nama }}</p>
                                </div>
                            </div>
                        </div>
                    </header>

                    <main class="flex gap-x-10 mt-10">
                        <div class="w-2/6">
                            <div class="border-b-2 mb-4">
                                <strong class="text-xl font-medium block">Contact Details</strong>
                                <ul class="mt-2 mb-6">
                                    <li class="px-3 mt-1"><strong class="mr-1">Phone </strong>
                                        <span class="block">{{ $mahasiswa->kontak ?? '-' }}</span>
                                    </li>
                                    <li class="px-3 mt-1"><strong class="mr-1">E-mail </strong>
                                        <span class="block">{{ $mahasiswa->user->email }}</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="border-b-2 mb-4">
                                <strong class="text-xl font-medium block mb-1">Prodi</strong>
                                <ul class="mb-4">
                                    <li class="px-3 mt-1">{{ $mahasiswa->prodi->nama }}</li>
                                </ul>
                            </div>

                            <div class="border-b-2 mb-4">
                                <strong class="text-xl font-medium block mb-1">Fakultas</strong>
                                <ul class="mb-6">
                                    <li class="px-3 mt-1">{{ $mahasiswa->fakultas->nama }}</li>
                                </ul>
                            </div>

                            <div class="flex justify-center">
                                <div class="bg-cover bg-no-repeat h-52 w-52 mt-8"
                                    style="background-image: url('{{ asset('images/iwu.png') }}')">
                                    <span class="sr-only">Logo IWU</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-4/6">
                            @foreach ($mahasiswa->prestasi as $p)
                                <section>
                                    <h2 class="text-2xl pb-1 border-b font-semibold">Prestasi</h2>
                                    <ul class="mt-4">
                                        <li class="pt-4 pb-6 border-b border-gray-200 mb-6">

                                            @php
                                                $tahunMulai = \Carbon\Carbon::parse($p->tanggal_mulai)->format('Y');
                                                $tahunSelesai = \Carbon\Carbon::parse($p->tanggal_selesai)->format('Y');
                                            @endphp

                                            <p class="flex justify-between text-sm">
                                                <strong class="text-base">{{ $p->nama_prestasi }}</strong>
                                                <span>
                                                    {{ $tahunMulai }} - {{ $tahunSelesai }}
                                                </span>
                                            </p>

                                            <p class="flex justify-between text-base">
                                                <span class="italic">{{ $p->nama_prestasi_en }}</span>
                                                <span>{{ $p->tempat ?? '-' }}</span>
                                            </p>

                                            @if ($p->berkasPrestasi && $p->berkasPrestasi->foto_upp)
                                                <strong class="block text-base mt-4 mb-4">Foto Sertifikat Kegiatan</strong>
                                                <div class="grid grid-cols-3 gap-4 mt-2">
                                                    <div>
                                                        <img class="w-80 h-40 object-cover rounded-lg"
                                                            src="{{ asset('storage/' . $p->berkasPrestasi->foto_upp) }}"
                                                            alt="Foto Sertifikat Kegiatan">
                                                    </div>

                                                    @php
                                                        $sertifikatKelulusan = is_string(
                                                            $p->berkasPrestasi->sertifikat_kelulusan,
                                                        )
                                                            ? json_decode(
                                                                $p->berkasPrestasi->sertifikat_kelulusan,
                                                                true,
                                                            )
                                                            : $p->berkasPrestasi->sertifikat_kelulusan;
                                                    @endphp

                                                    @if (is_array($sertifikatKelulusan) && count($sertifikatKelulusan) > 0)
                                                        @foreach ($sertifikatKelulusan as $file)
                                                            <div>
                                                                <img class="w-80 h-40 object-cover rounded-lg"
                                                                    src="{{ asset('storage/' . $file) }}"
                                                                    alt="Sertifikat Kelulusan">
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endif
                                        </li>
                                    </ul>
                                </section>
                            @endforeach
                        </div>
                    </main>
                </div>
            </div>
        </div>

        {{-- end CV --}}
    </div>


@endsection

{{-- Pindahkan skrip ke sini --}}
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNa5E+Us7+OyYG/04Yz3x1I+XNc3jf4niwDLsZWj4vVq22j8sojVgp2nRMI8MsvyBQvnktbaODly8s62/uoxXQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('download-img-btn').addEventListener('click', function() {
                const source = document.getElementById('cv-to-print');

                html2canvas(source, {
                    backgroundColor: '#ffffff',
                    scale: 2,
                    useCORS: true,
                }).then(originalCanvas => {
                    const fixedWidth = 1240; // px untuk A4@150dpi (~210mm)
                    const fixedHeight = 1754; // px untuk A4@150dpi (~297mm)

                    // Hitung skala yang mempertahankan aspect ratio
                    const scale = Math.min(
                        fixedWidth / originalCanvas.width,
                        fixedHeight / originalCanvas.height
                    );

                    const targetW = originalCanvas.width * scale;
                    const targetH = originalCanvas.height * scale;

                    // Canvas akhir
                    const resizedCanvas = document.createElement('canvas');
                    resizedCanvas.width = fixedWidth;
                    resizedCanvas.height = fixedHeight;
                    const ctx = resizedCanvas.getContext('2d');

                    // Optional: fill background putih
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, fixedWidth, fixedHeight);

                    // Gambar ter‑scale, ditengah horizontal dan vertikal
                    const dx = (fixedWidth - targetW) / 2;
                    const dy = (fixedHeight - targetH) / 2;
                    ctx.drawImage(originalCanvas,
                        0, 0, originalCanvas.width, originalCanvas.height,
                        dx, dy, targetW, targetH
                    );

                    // Download PNG hasilnya
                    const link = document.createElement('a');
                    link.download = `CV_{{ str_replace(' ', '_', $mahasiswa->user->name) }}.png`;
                    link.href = resizedCanvas.toDataURL('image/png');
                    link.click();
                });
            });
        });
    </script>
@endpush
