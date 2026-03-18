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

    @php
        $instagramGalleryEnabled = core()->getConfigData('general.design.instagram_gallery.enabled') ?? true;

        $defaultInstagramLink = 'https://www.instagram.com/ladiestudio._/';

        $instagramGalleryTitle = core()->getConfigData('general.design.instagram_gallery.title')
            ?: trans('shop::app.home.index.instagram-gallery');

        $instagramGalleryItems = [
            [
                'image' => core()->getConfigData('general.design.instagram_gallery.image_1'),
                'link'  => core()->getConfigData('general.design.instagram_gallery.link_1') ?: $defaultInstagramLink,
                'aos_delay' => 500,
            ],
            [
                'image' => core()->getConfigData('general.design.instagram_gallery.image_2'),
                'link'  => core()->getConfigData('general.design.instagram_gallery.link_2') ?: $defaultInstagramLink,
                'aos_delay' => 700,
            ],
            [
                'image' => core()->getConfigData('general.design.instagram_gallery.image_3'),
                'link'  => core()->getConfigData('general.design.instagram_gallery.link_3') ?: $defaultInstagramLink,
                'aos_delay' => 900,
            ],
            [
                'image' => core()->getConfigData('general.design.instagram_gallery.image_4'),
                'link'  => core()->getConfigData('general.design.instagram_gallery.link_4') ?: $defaultInstagramLink,
                'aos_delay' => 1100,
            ],
            [
                'image' => core()->getConfigData('general.design.instagram_gallery.image_5'),
                'link'  => core()->getConfigData('general.design.instagram_gallery.link_5') ?: $defaultInstagramLink,
                'aos_delay' => 1300,
            ],
        ];

        $instagramGalleryItems = array_values(array_filter($instagramGalleryItems, fn ($item) => ! empty($item['image'])));
    @endphp

    @if ($instagramGalleryEnabled && count($instagramGalleryItems))
        <div class="container mt-7 mx-auto max-lg:px-8 max-md:mt-8 max-sm:mt-7 max-sm:!px-4">
            <div data-aos="fade-up" aria-label="{{ trans('shop::app.home.index.instagram-gallery') }}">
                <h2
                    class="text-center text-xl mb-7 max-sm:text-xl"
                    data-aos="fade-up"
                    data-aos-delay="500"
                >
                    {{ $instagramGalleryTitle }}
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach ($instagramGalleryItems as $index => $item)
                        @php
                            $imageUrl = Storage::url($item['image']);
                        @endphp

                        <div
                            class="relative group overflow-hidden aspect-square"
                            data-aos="zoom-in"
                            data-aos-delay="{{ $item['aos_delay'] }}"
                        >
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ trans('shop::app.home.index.instagram-post', ['number' => $index + 1]) }}"
                                class="w-full h-full object-cover"
                            >

                            <a
                                href="{{ $item['link'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                            >
                                <span class="icon-instagram text-white text-3xl"></span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</x-shop::layouts>
