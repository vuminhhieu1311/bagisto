{!! view_render_event('bagisto.shop.layout.footer.before') !!}

<!--
    The category repository is injected directly here because there is no way
    to retrieve it from the view composer, as this is an anonymous component.
-->
@inject('themeCustomizationRepository', 'Webkul\Theme\Repositories\ThemeCustomizationRepository')

<!--
    This code needs to be refactored to reduce the amount of PHP in the Blade
    template as much as possible.
-->
@php
    $channel = core()->getCurrentChannel();

    $customization = $themeCustomizationRepository->findOneWhere([
        'type' => 'footer_links',
        'status' => 1,
        'theme_code' => $channel->theme,
        'channel_id' => $channel->id,
    ]);

    foreach ($customization->options as $footerLinkSection) {
        usort($footerLinkSection, function ($a, $b) {
            return $a['sort_order'] - $b['sort_order'];
        });
    }
@endphp

<footer class="mt-9 bg-lightOrange max-sm:mt-10">
    <div class="container mx-auto py-10 px-4 flex flex-col gap-4 md:flex-row justify-between items-start">
        <!-- Logo Section -->
        <div class="flex flex-col items-start mb-6 md:mb-0">
            <img src="{{ bagisto_asset('images/logo-footer.svg') }}" alt="Ladie Studio Logo" class="mb-4">
        </div>

        <!-- Contact Information -->
        <div class="text-sm text-gray-700 mb-6 md:mb-0">
            <h3 class="font-bold mb-2">LIÊN HỆ VỚI CHÚNG TÔI</h3>
            <ul>
                @if (optional($customization?->options)['column_1'])
                    @foreach ($customization->options['column_1'] ?? [] as $link)
                        <li class="mt-2">
                            <a href="{{ $link['url'] }}">
                                {{ $link['title'] }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <!-- Policies -->
        <div class="text-sm text-gray-700 mb-6 md:mb-0">
            <h3 class="font-bold mb-2">CHÍNH SÁCH</h3>
            <ul>
                @if (optional($customization?->options)['column_2'])
                    @foreach ($customization->options['column_2'] ?? [] as $link)
                        <li class="mt-2">
                            <a href="{{ $link['url'] }}">
                                {{ $link['title'] }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <!-- Newsletter Subscription -->
        <div class="text-sm text-gray-700">
            <h3 class="font-bold mb-2">Nhận tin khuyến mãi từ chúng tôi!</h3>
            <input type="email" placeholder="Nhập email của bạn.." class="border p-2 mb-2 w-full">
            <p>Khi đăng ký bạn đồng ý với <a href="#" class="underline">chính sách bảo mật</a> và <a
                    href="#" class="underline">điều khoản dịch vụ</a> của chúng tôi!</p>
            <button class="bg-black text-white py-2 px-4 mt-2 w-full md:w-auto">Đăng ký</button>
        </div>
    </div>
    <div class="bg-[#BFBEB5] text-[#565656] text-sm font-normal leading-6 py-4 px-4">
        ©2025 Ladie Studio All rights reserved. Developed by Latech
    </div>
</footer>

{!! view_render_event('bagisto.shop.layout.footer.after') !!}
