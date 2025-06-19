<x-filament::page class="filament-page min-h-screen bg-gray-50 py-10 px-6">
    <div class="max-w-5xl w-full mx-auto space-y-6">
        <!-- Judul besar -->
        <div class=" mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900">Jenis Berkas Pendukung Prestasi Mahasiswa</h1>
        </div>

        <div class="space-y-4 mt-52">
            {{-- Item 1 --}}
            <div class="flex items-center space-x-4 p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 cursor-default">
                <div class="flex-shrink-0 text-indigo-600 text-4xl">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" style="stroke:currentColor;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 12v.01M12 18v.01M6 6h12M6 6v12a2 2 0 002 2h8a2 2 0 002-2V6M6 6L4 4m0 0l2-2m-2 2v16a2 2 0 002 2h8a2 2 0 002-2v-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Bukti Prestasi</h3>
                    <p class="text-gray-600 mt-1">File PDF atau gambar (jpg, png) sebagai bukti prestasi.</p>
                </div>
            </div>

            {{-- Item 2 --}}
            <div class="flex items-center space-x-4 p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 cursor-default">
                <div class="flex-shrink-0 text-green-600 text-4xl">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" style="stroke:currentColor;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 015.656 5.656l-4.242 4.243a4 4 0 01-5.656-5.656M10.172 13.828a4 4 0 00-5.656-5.656L.273 12.345a4 4 0 005.656 5.656" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Link Sertifikat (Opsional)</h3>
                    <p class="text-gray-600 mt-1">Masukkan URL sertifikat online jika ada.</p>
                </div>
            </div>

            {{-- Item 3 --}}
            <div class="flex items-center space-x-4 p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 cursor-default">
                <div class="flex-shrink-0 text-yellow-500 text-4xl">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" style="stroke:currentColor;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8h3l3-3h6l3 3h3v9a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Foto Upacara Penyerahan Penghargaan (Opsional)</h3>
                    <p class="text-gray-600 mt-1">Foto saat menerima penghargaan sebagai dokumentasi.</p>
                </div>
            </div>

            {{-- Item 4 --}}
            <div class="flex items-center space-x-4 p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 cursor-default">
                <div class="flex-shrink-0 text-red-600 text-4xl">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" style="stroke:currentColor;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Surat Tugas/Izin</h3>
                    <p class="text-gray-600 mt-1">Dokumen resmi surat tugas atau izin terkait prestasi.</p>
                </div>
            </div>
        </div>
    </div>
</x-filament::page>