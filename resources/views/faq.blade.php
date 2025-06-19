@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
    <section class="py-8 px-4 mx-auto max-w-screen-xl sm:py-2 lg:px-6 bg-gray-50 rounded-lg shadow-md">
        <div class="">
            <h1 class="text-2xl font-semibold text-center text-gray-800 lg:text-3xl dark:text-white">Frequently asked
                questions</h1>

            <div class="mt-12 space-y-8">

                {{-- FAQ --}}
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700">
                    <button class="faq-btn flex items-center justify-between w-full p-8">
                        <h1 class="font-semibold text-xl text-gray-700 dark:text-white">
                            Apa itu Sistem Informas Prestasi?
                        </h1>
                        <span class="icon-box text-white bg-purple-500 rounded-full">
                            <svg class="icon w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path class="icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>
                    <hr class="faq-divider hidden border-gray-200 dark:border-gray-700">
                    <p class="faq-content hidden p-8 text-md text-gray-500 dark:text-gray-300">
                        Sistem digital untuk mencatat dan memantau prestasi mahasiswa.
                    </p>
                </div>
                {{-- FAQ --}}
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700">
                    <button class="faq-btn flex items-center justify-between w-full p-8">
                        <h1 class="font-semibold text-xl text-gray-700 dark:text-white">
                            Apa tujuan utama sistem ini?
                        </h1>
                        <span class="icon-box text-white bg-purple-500 rounded-full">
                            <svg class="icon w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path class="icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>
                    <hr class="faq-divider hidden border-gray-200 dark:border-gray-700">
                    <p class="faq-content hidden p-8 text-md text-gray-500 dark:text-gray-300">
                        Mendata prestasi, mendukung akreditasi, dan memotivasi mahasiswa.
                    </p>
                </div>
                {{-- FAQ --}}
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700">
                    <button class="faq-btn flex items-center justify-between w-full p-8">
                        <h1 class="font-semibold text-xl text-gray-700 dark:text-white">
                            Siapa saja yang dapat menggunakan sistem ini?
                        </h1>
                        <span class="icon-box text-white bg-purple-500 rounded-full">
                            <svg class="icon w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path class="icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>
                    <hr class="faq-divider hidden border-gray-200 dark:border-gray-700">
                    <p class="faq-content hidden p-8 text-md text-gray-500 dark:text-gray-300">
                        Mahasiswa, dan admin kampus.
                    </p>
                </div>
                {{-- FAQ --}}
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700">
                    <button class="faq-btn flex items-center justify-between w-full p-8">
                        <h1 class="font-semibold text-xl text-gray-700 dark:text-white">
                            Jenis prestasi apa saja yang dapat dicatat dalam sistem ini?
                        </h1>
                        <span class="icon-box text-white bg-purple-500 rounded-full">
                            <svg class="icon w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path class="icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>
                    <hr class="faq-divider hidden border-gray-200 dark:border-gray-700">
                    <p class="faq-content hidden p-8 text-md text-gray-500 dark:text-gray-300">
                        Akademik, non-akademik, sertifikasi, dan kegiatan sosial.
                    </p>
                </div>
                {{-- FAQ --}}
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700">
                    <button class="faq-btn flex items-center justify-between w-full p-8">
                        <h1 class="font-semibold text-xl text-gray-700 dark:text-white">
                            Bagaimana cara mahasiswa mencatat prestasi di sistem?
                        </h1>
                        <span class="icon-box text-white bg-purple-500 rounded-full">
                            <svg class="icon w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path class="icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>
                    <hr class="faq-divider hidden border-gray-200 dark:border-gray-700">
                    <p class="faq-content hidden p-8 text-md text-gray-500 dark:text-gray-300">
                        Login, isi form, unggah bukti, lalu kirim untuk diverifikasi.
                    </p>
                </div>
                {{-- FAQ --}}
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700">
                    <button class="faq-btn flex items-center justify-between w-full p-8">
                        <h1 class="font-semibold text-xl text-gray-700 dark:text-white">
                            Apakah dokumen pendukung diperlukan?
                        </h1>
                        <span class="icon-box text-white bg-purple-500 rounded-full">
                            <svg class="icon w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path class="icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>
                    <hr class="faq-divider hidden border-gray-200 dark:border-gray-700">
                    <p class="faq-content hidden p-8 text-md text-gray-500 dark:text-gray-300">
                        Ya, seperti sertifikat atau dokumentasi kegiatan.
                    </p>
                </div>
                {{-- FAQ --}}
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700">
                    <button class="faq-btn flex items-center justify-between w-full p-8">
                        <h1 class="font-semibold text-xl text-gray-700 dark:text-white">
                            Bagaimana proses verifikasi prestasi?
                        </h1>
                        <span class="icon-box text-white bg-purple-500 rounded-full">
                            <svg class="icon w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path class="icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>
                    <hr class="faq-divider hidden border-gray-200 dark:border-gray-700">
                    <p class="faq-content hidden p-8 text-md text-gray-500 dark:text-gray-300">
                        Dosen/admin cek bukti → setujui atau minta perbaikan.
                    </p>
                </div>
                {{-- FAQ --}}
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700">
                    <button class="faq-btn flex items-center justify-between w-full p-8">
                        <h1 class="font-semibold text-xl text-gray-700 dark:text-white">
                            Apakah mahasiswa dapat mengedit data yang sudah diunggah?
                        </h1>
                        <span class="icon-box text-white bg-purple-500 rounded-full">
                            <svg class="icon w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path class="icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>
                    <hr class="faq-divider hidden border-gray-200 dark:border-gray-700">
                    <p class="faq-content hidden p-8 text-md text-gray-500 dark:text-gray-300">
                        Bisa sebelum diverifikasi. Setelah itu harus ajukan revisi.
                    </p>
                </div>
                {{-- FAQ --}}
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700">
                    <button class="faq-btn flex items-center justify-between w-full p-8">
                        <h1 class="font-semibold text-xl text-gray-700 dark:text-white">
                            Bagaimana cara mendapatkan laporan rekap prestasi?
                        </h1>
                        <span class="icon-box text-white bg-purple-500 rounded-full">
                            <svg class="icon w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path class="icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>
                    <hr class="faq-divider hidden border-gray-200 dark:border-gray-700">
                    <p class="faq-content hidden p-8 text-md text-gray-500 dark:text-gray-300">
                        Gunakan fitur laporan, bisa diunduh dalam PDF atau Excel.
                    </p>
                </div>

                {{-- Tambahkan lebih banyak FAQ jika perlu, copy struktur di atas --}}

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.faq-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const parent = btn.closest('div');
                    const content = parent.querySelector('.faq-content');
                    const divider = parent.querySelector('.faq-divider');
                    const iconPath = btn.querySelector('.icon-path');

                    const isOpen = !content.classList.contains('hidden');

                    // Toggle content & divider
                    content.classList.toggle('hidden', isOpen);
                    divider.classList.toggle('hidden', isOpen);

                    // Toggle icon (plus ↔ minus)
                    iconPath.setAttribute('d', isOpen ? 'M12 6v6m0 0v6m0-6h6m-6 0H6' : 'M18 12H6');
                });
            });
        });
    </script>
@endpush
