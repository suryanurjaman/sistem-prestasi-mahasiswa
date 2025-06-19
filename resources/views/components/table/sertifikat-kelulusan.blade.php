<div class="flex flex-wrap gap-2">
    @foreach ($getState() ?? [] as $image)
        <a href="{{ asset('storage/' . $image) }}" target="_blank">
            <img src="{{ asset('storage/' . $image) }}" class="w-16 h-16 object-cover border" />
        </a>
    @endforeach
</div>
