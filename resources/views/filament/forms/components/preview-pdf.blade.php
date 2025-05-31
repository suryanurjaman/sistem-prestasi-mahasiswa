@props(['state'])

@php
    $actualState = $state instanceof Closure ? $state() : $state;
    $url = $actualState ? \Illuminate\Support\Facades\Storage::url($actualState) : null;
@endphp

@if ($url)
    <a href="{{ $url }}" target="_blank" class="text-blue-600 underline hover:text-blue-800">
        Lihat File
    </a>
@else
    <p class="text-sm text-gray-500 italic text-center">Belum ada file</p>
@endif
