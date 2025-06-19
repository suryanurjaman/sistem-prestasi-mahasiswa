@if (is_array($getState()) && count($getState()))
    <ul class="list-disc pl-4 text-blue-600">
        @foreach ($getState() as $item)
            <li>
                <a href="{{ $item['url'] }}" target="_blank" class="underline">
                    {{ \Illuminate\Support\Str::limit($item['url'], 40) }}
                </a>
            </li>
        @endforeach
    </ul>
@else
    <span class="text-gray-500 italic">Tidak ada link</span>
@endif
