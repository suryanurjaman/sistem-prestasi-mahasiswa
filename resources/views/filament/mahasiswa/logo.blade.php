<div class="flex items-center gap-4 space-x-2">
    <img src="{{ asset('storage/images/iwu.svg') }}" alt="Logo" class="h-8 w-auto">

    @auth
        <span class="text-lg font-bold text-gray-800">
            {{ auth()->user()->name }}
        </span>
    @else
        <span class="text-lg font-bold text-gray-800">
            Sistem Informasi Prestasi
        </span>
    @endauth
</div>
