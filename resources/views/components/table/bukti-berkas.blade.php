@php
$state = $getState();
$ext = strtolower(pathinfo($state, PATHINFO_EXTENSION));
$url = \Storage::url($state);
@endphp

@if(blank($state))
<div class="fi-ta-placeholder text-sm leading-6 text-gray-400">
    Berkas tidak ada
</div>
@elseif(in_array($ext, ['jpg', 'jpeg', 'png']))
<a href="{{ $url }}" target="_blank" class="block my-4">
    <img src="{{ $url }}" alt="bukti" class="h-16 w-auto object-cover rounded-md hover:scale-105 transition-transform duration-200" />
</a>
@elseif($ext === 'pdf')
<a href="{{ $url }}" target="_blank" class="flex items-center gap-2 text-sm text-blue-600 hover:underline">
    <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="PDF" class="h-6 w-6" />
    <span class="truncate max-w-[100px]">Lihat PDF</span>
</a>
@else
<a href="{{ $url }}" target="_blank" class="text-sm text-blue-600 hover:underline truncate max-w-[100px] block">
    Lihat File
</a>
@endif
