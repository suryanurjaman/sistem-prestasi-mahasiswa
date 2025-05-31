@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $path = $file($record);
    $ext = Str::lower(pathinfo($path, PATHINFO_EXTENSION));
    $url = $path ? Storage::url($path) : null;
@endphp

@if (!$path)
    <p>Tidak ada berkas.</p>
@elseif (in_array($ext, ['jpg', 'jpeg', 'png']))
    <img src="{{ $url }}" style="max-width:300px; max-height:200px;" alt="Preview Berkas">
@elseif ($ext === 'pdf')
    <a href="{{ $url }}" target="_blank" class="text-blue-600 underline">Download File (PDF)</a>
@else
    <a href="{{ $url }}" target="_blank" class="text-blue-600 underline">Download File</a>
@endif
