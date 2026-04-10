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

        @if ($customization->id === 15)
            @php
                $homeBannersEnabled = core()->getConfigData('general.design.home_banners.enabled') ?? true;

                $homeBanners = [
                    [
                        'image'     => core()->getConfigData('general.design.home_banners.image_1'),
                        'link'      => core()->getConfigData('general.design.home_banners.link_1') ?: '/shop',
                        'aos_delay' => 200,
                        'fallback'  => 'storage/theme/15/3ItN8XRle62WDIxKupltEEjOzAk5j08hyANvaVdG.webp',
                    ],
                    [
                        'image'     => core()->getConfigData('general.design.home_banners.image_2'),
                        'link'      => core()->getConfigData('general.design.home_banners.link_2') ?: '/trending',
                        'aos_delay' => 500,
                        'fallback'  => 'storage/theme/15/NS6Dku193bePXXfIqihDxlv11RbU4UdAhqHqZ8PD.webp',
                    ],
                    [
                        'image'     => core()->getConfigData('general.design.home_banners.image_3'),
                        'link'      => core()->getConfigData('general.design.home_banners.link_3') ?: '/shop',
                        'aos_delay' => 700,
                        'fallback'  => 'storage/theme/15/HiLy5fSZvSCjpNSyjejzD2lxKdqKdgfX3O83ROIY.webp',
                    ],
                ];
            @endphp

            <div class="product-showcase mx-auto container mt-12 max-lg:px-8 max-md:mt-8 max-sm:mt-7 max-sm:!px-4">
                <p class="showcase-description" data-aos="fade-up">Nâng tầm phong cách sống với tủ đồ thông minh và đẳng cấp hơn.
                    <br>Bộ sưu tập của chúng tôi được thiết kế bền vững, hướng đến giá trị lâu dài.</p>
                <div class="product-grid grid grid-cols-1 md:grid-cols-3 gap-6 mt-5">
                    @if ($homeBannersEnabled)
                        @foreach ($homeBanners as $banner)
                            @php
                                $bannerSrc = ! empty($banner['image'])
                                    ? Storage::url($banner['image'])
                                    : $banner['fallback'];
                            @endphp

                            <div
                                class="product-item relative group overflow-hidden"
                                data-aos="zoom-in"
                                data-aos-delay="{{ $banner['aos_delay'] }}"
                            >
                                <a href="{{ $banner['link'] }}">
                                    <img
                                        class="lazy product-image w-full h-full object-cover"
                                        data-src="{{ $bannerSrc }}"
                                    >
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @elseif ($customization->id === 8)
            @php
                $homeCollectionsEnabled = core()->getConfigData('general.design.home_collections.enabled') ?? true;

                $homeCollections = [
                    [
                        'image'     => core()->getConfigData('general.design.home_collections.image_1'),
                        'link'      => core()->getConfigData('general.design.home_collections.link_1') ?: '/shop',
                        'aos_delay' => 600,
                        'fallback'  => 'storage/theme/8/9KMP8wOUTKQjlfB47E5hMQYFqFXt83g88ppsZqIm.webp',
                    ],
                    [
                        'image'     => core()->getConfigData('general.design.home_collections.image_2'),
                        'link'      => core()->getConfigData('general.design.home_collections.link_2') ?: '/shop',
                        'aos_delay' => 800,
                        'fallback'  => 'storage/theme/8/ledTRLKJauCPuwbcCFV0VL3icISrd5CcASNNcl0a.webp',
                    ],
                ];
            @endphp

            <div class="collection-section container mt-10 mb-10 max-lg:px-8 max-md:mt-8 max-sm:mt-7 max-sm:!px-4">
                <div class="collection-card-wrapper grid grid-cols-2 gap-6 max-md:grid-cols-1">
                    @if ($homeCollectionsEnabled)
                        @foreach ($homeCollections as $index => $collection)
                            @php
                                $collectionSrc = ! empty($collection['image'])
                                    ? Storage::url($collection['image'])
                                    : $collection['fallback'];
                            @endphp

                            <div
                                class="single-collection-card"
                                data-aos="{{ $index === 0 ? 'fade-right' : 'fade-left' }}"
                                data-aos-delay="{{ $collection['aos_delay'] }}"
                            >
                                <a href="{{ $collection['link'] }}">
                                    <img
                                        class="lazy"
                                        data-src="{{ $collectionSrc }}"
                                        alt="{{ trans('shop::app.home.index.instagram-post', ['number' => $index + 1]) }}"
                                    >
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @else
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
        @endif
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
