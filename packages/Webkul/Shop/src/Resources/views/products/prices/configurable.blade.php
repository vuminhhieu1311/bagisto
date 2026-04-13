@if ($prices['final']['price'] < $prices['regular']['price'])
    <p
        class="final-price text-zinc-500 line-through max-sm:leading-4"
        aria-label="{{ $prices['regular']['formatted_price'] }}"
    >
        {{ $prices['regular']['formatted_price'] }}
    </p>

    <p class="max-sm:leading-4">
        {{ $prices['final']['formatted_price'] }}
    </p>
@else
    <p class="final-price max-sm:leading-4">
        {{ $prices['regular']['formatted_price'] }}
    </p>
@endif