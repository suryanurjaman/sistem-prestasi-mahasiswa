@props([
    /**
     * Array associative: ['Label 1' => value1, 'Label 2' => value2, …]
     */
    'data',
    /** Nama kolom kedua, misal "Fakultas", "Prodi", dsb. */
    'label',
])

<div class="w-full lg:w-1/2 bg-gray-50 dark:bg-gray-800 p-6 rounded-lg shadow-md overflow-x-auto">
    <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th class="px-6 py-3">No</th>
                <th class="px-6 py-3">{{ $label }}</th>
                <th class="px-6 py-3">Jumlah</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($data as $key => $value)
                <tr>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $key }}</td>
                    <td class="px-6 py-4">{{ $value }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        Tidak ada data.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
