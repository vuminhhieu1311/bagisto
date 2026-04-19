@php
    $regularAmount = (float) ($prices['regular']['price'] ?? 0);
    $finalAmount = (float) ($prices['final']['price'] ?? 0);
    $hasVariantDiscount = $regularAmount > $finalAmount;
@endphp

<p class="price-label text-sm text-zinc-500 max-sm:text-xs">
    @lang('shop::app.products.prices.configurable.as-low-as')
</p>

@if ($hasVariantDiscount)
    <p
        class="regular-price text-lg text-gray-500 line-through max-sm:leading-4"
        aria-label="{{ $prices['regular']['formatted_price'] }}"
    >
        {{ $prices['regular']['formatted_price'] }}
    </p>

    <p class="final-price max-sm:leading-4">
        {{ $prices['final']['formatted_price'] }}
    </p>
@else
    <p
        class="regular-price text-lg text-gray-500 line-through"
        style="display: none;"
        aria-hidden="true"
    ></p>

    <p class="final-price max-sm:leading-4">
        {{ $prices['regular']['formatted_price'] }}
    </p>
@endif