@php
    use Illuminate\Support\Facades\Storage;

    $url = $value ? Storage::url($value) : null;
    $ext = $value ? strtolower(pathinfo($value, PATHINFO_EXTENSION)) : null;
@endphp

@if (!$value)
    —
@elseif (in_array($ext, ['jpg', 'jpeg', 'png']))
    <img src="{{ $url }}" alt="preview" class="h-12 rounded-md object-cover max-w-[100px]" />
@elseif ($ext === 'pdf')
    <a href="{{ $url }}" target="_blank" class="inline-flex items-center gap-2">
        <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="PDF" class="h-5 w-5" />
        <span class="text-sm text-blue-600 hover:underline">Lihat PDF</span>
    </a>
@else
    <a href="{{ $url }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
@endif
