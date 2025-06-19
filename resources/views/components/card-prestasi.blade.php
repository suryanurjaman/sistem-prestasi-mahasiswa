{{-- Komponen Card Prestasi Berdasarkan Label --}}
<div
    class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center justify-center mb-4">
        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">{{ $label }}</h5>
    </div>
    <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($entities as $entity)
                <li class="py-3 sm:py-4">
                    <div class="flex items-center">
                        <div class="flex-1 min-w-0 ms-4">
                            <p class="text-md font-medium text-gray-900 truncate dark:text-white">
                                {{ $entity['name'] }}
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            {{ $entity['point'] }} Poin
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
