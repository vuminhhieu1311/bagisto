@php
    $channel = core()->getCurrentChannel();
@endphp

<!-- SEO Meta Content -->
@push ('meta')
    <meta
        name="title"
        content="{{ $channel->home_seo['meta_title'] ?? '' }}"
    />

    <meta
        name="description"
        content="{{ $channel->home_seo['meta_description'] ?? '' }}"
    />

    <meta
        name="keywords"
        content="{{ $channel->home_seo['meta_keywords'] ?? '' }}"
    />
@endPush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{  $channel->home_seo['meta_title'] ?? '' }}
    </x-slot>

    <!-- Loop over the theme customization -->
    @foreach ($customizations as $customization)
        @php ($data = $customization->options) @endphp

        <!-- Static content -->
        @switch ($customization->type)
            @case ($customization::IMAGE_CAROUSEL)
                <!-- Image Carousel -->
                <x-shop::carousel
                    :options="$data"
                    aria-label="{{ trans('shop::app.home.index.image-carousel') }}"
                />

                @break
            @case ($customization::STATIC_CONTENT)
                <!-- push style -->
                @if (! empty($data['css']))
                    @push ('styles')
                        <style>
                            {{ $data['css'] }}
                        </style>
                    @endpush
                @endif

                <!-- render html -->
                @if (! empty($data['html']))
                    {!! $data['html'] !!}
                @endif

                @break
            @case ($customization::CATEGORY_CAROUSEL)
                <!-- Categories carousel -->
                <x-shop::categories.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.categories.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.home.index')"
                    aria-label="{{ trans('shop::app.home.index.categories-carousel') }}"
                />

                @break
            @case ($customization::PRODUCT_CAROUSEL)
                <!-- Product Carousel -->
                <x-shop::products.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.products.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.search.index', $data['filters'] ?? [])"
                    aria-label="{{ trans('shop::app.home.index.product-carousel') }}"
                />

                @break
        @endswitch
    @endforeach

    <div class="container mt-7 mx-auto max-lg:px-8 max-md:mt-8 max-sm:mt-7 max-sm:!px-4">
        <!-- Instagram Gallery Section -->
        <div>
            <h2 class="text-center text-xl mb-7 max-sm:text-xl">Shop Instagram</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <!-- Image 1 -->
                <div class="relative group overflow-hidden aspect-square">
                    <img
                        src="{{ bagisto_asset('images/insta1.png') }}"
                        alt="Instagram post 1"
                        class="w-full h-full object-cover"
                    >
                    <a
                        href="#"
                        class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                    >
                        <span class="icon-instagram text-white text-3xl"></span>
                    </a>
                </div>

                <!-- Image 2 -->
                <div class="relative group overflow-hidden aspect-square">
                    <img
                        src="{{ bagisto_asset('images/insta2.png') }}"
                        alt="Instagram post 2"
                        class="w-full h-full object-cover"
                    >
                    <a
                        href="#"
                        class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                    >
                        <span class="icon-instagram text-white text-3xl"></span>
                    </a>
                </div>

                <!-- Image 3 -->
                <div class="relative group overflow-hidden aspect-square">
                    <img
                        src="{{ bagisto_asset('images/insta3.png') }}"
                        alt="Instagram post 3"
                        class="w-full h-full object-cover"
                    >
                    <a
                        href="#"
                        class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                    >
                        <span class="icon-instagram text-white text-3xl"></span>
                    </a>
                </div>

                <!-- Image 4 -->
                <div class="relative group overflow-hidden aspect-square">
                    <img
                        src="{{ bagisto_asset('images/insta4.png') }}"
                        alt="Instagram post 4"
                        class="w-full h-full object-cover"
                    >
                    <a
                        href="#"
                        class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                    >
                        <span class="icon-instagram text-white text-3xl"></span>
                    </a>
                </div>

                <!-- Image 5 -->
                <div class="relative group overflow-hidden aspect-square">
                    <img
                        src="{{ bagisto_asset('images/insta5.png') }}"
                        alt="Instagram post 5"
                        class="w-full h-full object-cover"
                    >
                    <a
                        href="#"
                        class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                    >
                        <span class="icon-instagram text-white text-3xl"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-shop::layouts>
