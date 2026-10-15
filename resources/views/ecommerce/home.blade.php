@extends('ecommerce.master')

@section('main-section')
    <!-- Home: Responsive 16:9 Hero Banner Slider -->
    <section class="bg-[#faf9f6] py-2 sm:py-4 md:py-6 border-b border-stone-200/60">
        <div class="container mx-auto px-2 sm:px-4 max-w-7xl">
            <div class="w-full">
                <div id="heroSplide" class="splide rounded-sm md:rounded-md overflow-hidden shadow-xs md:shadow-sm bg-white"
                    aria-label="Harosa Hero Banner">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @if(!empty($banners) && count($banners) > 0)
                                @foreach($banners as $banner)
                                    <li class="splide__slide relative bg-stone-100 flex items-center justify-center overflow-hidden">
                                        @if($banner->link_url)
                                            <a href="{{ $banner->link_url }}" class="block w-full">
                                                <img src="{{ $banner->image_url }}" alt="{{ $banner->title ?? 'Hero Banner' }}"
                                                    class="w-full h-auto block object-contain">
                                            </a>
                                        @else
                                            <img src="{{ $banner->image_url }}" alt="{{ $banner->title ?? 'Hero Banner' }}"
                                                class="w-full h-auto block object-contain">
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                <!-- Harosa Default Beauty Hero Slide -->
                                <li class="splide__slide relative min-h-[260px] sm:min-h-[360px] md:min-h-[460px] bg-[#f5ede3] flex items-center overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-[#fbf8f3] via-[#f7f0e4]/80 to-transparent z-0"></div>
                                    <div class="container mx-auto px-4 md:px-12 relative z-10 flex flex-col items-end text-right ml-auto">
                                        <div class="max-w-xs sm:max-w-md">
                                            <span class="text-[#a28e46] text-[10px] sm:text-xs md:text-sm font-semibold uppercase tracking-widest block mb-1">Cosmetics & Spa</span>
                                            <h1 class="font-serif text-xl sm:text-3xl md:text-5xl font-bold text-[#a28e46] italic leading-tight mb-1">
                                                The Body Care
                                            </h1>
                                            <h3 class="text-gray-500 font-sans text-xs sm:text-sm md:text-lg font-light tracking-widest uppercase mb-3 sm:mb-6">
                                                FRUIT FACE PACK
                                            </h3>
                                            <a href="{{ route('product.archive') }}"
                                                class="inline-flex items-center gap-2 border border-[#a28e46] sm:border-2 text-[#a28e46] hover:bg-[#a28e46] hover:text-white font-semibold text-[10px] sm:text-xs tracking-widest uppercase px-4 sm:px-7 py-1.5 sm:py-2.5 rounded-full transition-all duration-300 no-underline">
                                                SHOP NOW
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Featured Categories Showcase -->
    @if(isset($featuredCategories) && count($featuredCategories) > 0)
        <section class="py-6 sm:py-10 bg-white">
            <div class="container mx-auto px-3 sm:px-4 max-w-7xl">
                <div class="flex items-center justify-between pb-2.5 sm:pb-3.5 mb-4 sm:mb-6 border-b border-stone-200">
                    <div class="relative">
                        <h2 class="text-sm sm:text-base md:text-2xl font-serif font-bold text-gray-900 uppercase tracking-wide m-0">
                            FEATURED CATEGORIES
                        </h2>
                        <span class="absolute -bottom-[11px] sm:-bottom-[15px] left-0 w-12 sm:w-16 h-[2px] bg-[#a28e46]"></span>
                    </div>
                    <a href="{{ route('categories') }}"
                        class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-[#a28e46] transition-colors no-underline flex items-center gap-1">
                        <span>View All</span>
                        <i class="fa-solid fa-arrow-right text-[9px]"></i>
                    </a>
                </div>

                <div id="categorySplide" class="splide" aria-label="Category Carousel">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($featuredCategories as $category)
                                <li class="splide__slide">
                                    <a href="{{ route('product.archive') }}?category={{ $category->slug }}"
                                        class="group block relative h-48 sm:h-60 md:h-72 rounded-sm md:rounded-md overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 no-underline">
                                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/25 to-transparent"></div>
                                        <div class="absolute bottom-0 left-0 right-0 p-2.5 sm:p-4 md:p-5 text-white flex flex-col items-start">
                                            <span class="font-serif font-bold text-xs sm:text-sm md:text-lg uppercase tracking-wider mb-1 line-clamp-1 group-hover:text-[#f3e9cf] transition-colors leading-tight">
                                                {{ $category->name }}
                                            </span>
                                            <span class="text-[9px] sm:text-[10px] md:text-[11px] font-semibold uppercase tracking-wider text-[#a28e46] bg-white/95 px-2 sm:px-2.5 py-0.5 rounded-xs flex items-center gap-1 shadow-xs">
                                                <span>Shop Now</span>
                                                <i class="fa-solid fa-chevron-right text-[7px]"></i>
                                            </span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Best Deals / Top Offers Product Carousel (Right after Categories) -->
    <section class="py-8 sm:py-12 bg-[#faf9f6] border-t border-b border-stone-200/60">
        <div class="container mx-auto px-3 sm:px-4 max-w-7xl">
            <div class="flex items-center justify-between pb-2.5 sm:pb-3.5 mb-5 sm:mb-7 border-b border-stone-200">
                <div class="relative">
                    <h2 class="text-sm sm:text-base md:text-2xl font-serif font-bold text-gray-900 uppercase tracking-wide m-0">
                        TOP DEALS & OFFERS
                    </h2>
                    <span class="absolute -bottom-[11px] sm:-bottom-[15px] left-0 w-12 sm:w-16 h-[2px] bg-[#a28e46]"></span>
                </div>
                <a href="{{ route('best.deal') }}"
                    class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-[#a28e46] transition-colors no-underline flex items-center gap-1">
                    <span>View All Deals</span>
                    <i class="fa-solid fa-arrow-right text-[9px]"></i>
                </a>
            </div>

            <!-- Best Deals Carousel -->
            <div id="weeklyDealsSplide" class="splide" aria-label="Top Deals" style="visibility:hidden;">
                <div class="splide__track">
                    <ul class="splide__list" id="weeklyDealsSplideList"></ul>
                </div>
            </div>
            <div id="weeklyDealsFallback" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-6"></div>
        </div>
    </section>

    <!-- Harosa 2 Promotional Banners Section (1 Row 2 Columns - Image Only with Luxury Curtain / Light Sweep Animation) -->
    <section class="py-4 sm:py-6 bg-[#faf9f6] border-t border-b border-stone-200/60">
        <div class="container mx-auto px-3 sm:px-4 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                @php
                    $b1 = $vlogBottomBanners[0] ?? null;
                    $b2 = $vlogBottomBanners[1] ?? null;
                @endphp

                <!-- Column 1 Banner (Image Only) -->
                <div class="w-full overflow-hidden rounded-sm">
                    @if($b1 && $b1->image_url)
                        <a href="{{ $b1->link_url ?? route('product.archive') }}" class="harosa-banner-box w-full block">
                            <img src="{{ $b1->image_url }}" alt="{{ $b1->title ?? 'Promotion Banner 1' }}"
                                class="w-full h-auto min-h-[120px] max-h-[220px] object-cover">
                        </a>
                    @else
                        <a href="{{ route('product.archive') }}" class="harosa-banner-box w-full block">
                            <img src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&auto=format&fit=crop&q=80"
                                alt="Skin & Body Care" class="w-full h-auto min-h-[120px] max-h-[220px] object-cover">
                        </a>
                    @endif
                </div>

                <!-- Column 2 Banner (Image Only) -->
                <div class="w-full overflow-hidden rounded-sm">
                    @if($b2 && $b2->image_url)
                        <a href="{{ $b2->link_url ?? route('product.archive') }}" class="harosa-banner-box w-full block">
                            <img src="{{ $b2->image_url }}" alt="{{ $b2->title ?? 'Promotion Banner 2' }}"
                                class="w-full h-auto min-h-[120px] max-h-[220px] object-cover">
                        </a>
                    @else
                        <a href="{{ route('product.archive') }}" class="harosa-banner-box w-full block">
                            <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=800&auto=format&fit=crop&q=80"
                                alt="Organic Creams" class="w-full h-auto min-h-[120px] max-h-[220px] object-cover">
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Harosa Signature Tabbed Products Showcase (• NEW ARRIVAL • BESTSELLER • FEATURED PRODUCTS) -->
    <section class="py-8 sm:py-12 bg-white">
        <div class="container mx-auto px-3 sm:px-4 max-w-7xl">

            <!-- Tab Navigation Header -->
            <div class="flex items-center justify-center gap-2 sm:gap-6 md:gap-10 pb-5 sm:pb-8 text-center">
                <button type="button"
                    class="harosa-tab-btn active text-[11px] sm:text-sm md:text-base font-bold uppercase tracking-wider text-[#a28e46] transition-all flex items-center gap-1 sm:gap-2 cursor-pointer pb-1.5 border-b-2 border-[#a28e46] focus:outline-none flex-shrink-0"
                    data-tab-target="tab-new-arrivals">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#a28e46] hidden sm:inline-block"></span>
                    <span class="hidden sm:inline">NEW ARRIVALS</span>
                    <span class="sm:hidden">NEW IN</span>
                </button>

                <button type="button"
                    class="harosa-tab-btn text-[11px] sm:text-sm md:text-base font-bold uppercase tracking-wider text-gray-400 hover:text-[#a28e46] transition-all flex items-center gap-1 sm:gap-2 cursor-pointer pb-1.5 border-b-2 border-transparent focus:outline-none flex-shrink-0"
                    data-tab-target="tab-bestseller">
                    <span class="w-1.5 h-1.5 rounded-full bg-gray-300 hidden sm:inline-block dot-indicator"></span>
                    <span>BESTSELLER</span>
                </button>

                <button type="button"
                    class="harosa-tab-btn text-[11px] sm:text-sm md:text-base font-bold uppercase tracking-wider text-gray-400 hover:text-[#a28e46] transition-all flex items-center gap-1 sm:gap-2 cursor-pointer pb-1.5 border-b-2 border-transparent focus:outline-none flex-shrink-0"
                    data-tab-target="tab-featured">
                    <span class="w-1.5 h-1.5 rounded-full bg-gray-300 hidden sm:inline-block dot-indicator"></span>
                    <span>FEATURED</span>
                </button>
            </div>

            <!-- Tab 1: New Arrivals -->
            <div id="tab-new-arrivals" class="harosa-tab-pane block">
                <div id="newArrivalsSplide" class="splide" aria-label="New Arrivals" style="visibility:hidden;">
                    <div class="splide__track">
                        <ul class="splide__list" id="newArrivalsSplideList"></ul>
                    </div>
                </div>
                <div id="newArrivalsFallback" class="grid grid-cols-2 md:grid-cols-4 gap-6"></div>
            </div>

            <!-- Tab 2: Bestseller (Top Selling) -->
            <div id="tab-bestseller" class="harosa-tab-pane hidden">
                <div id="mostSoldSplide" class="splide" aria-label="Bestsellers" style="visibility:hidden;">
                    <div class="splide__track">
                        <ul class="splide__list" id="mostSoldSplideList"></ul>
                    </div>
                </div>
                <div id="mostSoldFallback" class="grid grid-cols-2 md:grid-cols-4 gap-6"></div>
            </div>

            <!-- Tab 3: Featured (Best Deals) -->
            <div id="tab-featured" class="harosa-tab-pane hidden">
                <div id="bestDealsSplide" class="splide" aria-label="Featured Products" style="visibility:hidden;">
                    <div class="splide__track">
                        <ul class="splide__list" id="bestDealsSplideList"></ul>
                    </div>
                </div>
                <div id="bestDealsFallback" class="grid grid-cols-2 md:grid-cols-4 gap-6"></div>
            </div>

        </div>
    </section>

    <!-- Harosa 3-Column Luxury Feature Spotlight -->
    <section class="py-8 sm:py-12 bg-[#faf9f6] border-t border-stone-200/60">
        <div class="container mx-auto px-3 sm:px-4 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                @php
                    $defaultSpotlights = [
                        [
                            'image' => 'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=600&auto=format&fit=crop&q=80',
                            'subtitle' => 'SALE 30% OFF',
                            'title' => 'NSI BALANCE GEL BODY BUILDER NUDE',
                            'desc' => 'Praesent volutpat ut nisl in hendrerit.',
                            'link' => route('product.archive'),
                            'btn_text' => 'SHOP NOW'
                        ],
                        [
                            'image' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=600&auto=format&fit=crop&q=80',
                            'subtitle' => 'SALE 50% OFF',
                            'title' => 'BUY NUDE BY BILL BLASS FOR HER EDC 100 ML',
                            'desc' => 'Praesent volutpat ut nisl in hendrerit.',
                            'link' => route('product.archive'),
                            'btn_text' => 'SHOP NOW'
                        ],
                        [
                            'image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=600&auto=format&fit=crop&q=80',
                            'subtitle' => 'SALE 20% OFF',
                            'title' => 'PBM CREAM FOUNDATION MAKEUP',
                            'desc' => 'Praesent volutpat ut nisl in hendrerit.',
                            'link' => route('product.archive'),
                            'btn_text' => 'SHOP NOW'
                        ]
                    ];
                @endphp

                @for($i = 0; $i < 3; $i++)
                    @php
                        $item = (isset($featureDeals) && isset($featureDeals[$i])) ? $featureDeals[$i] : null;
                        $img = $item ? ($item->image_url ?? $defaultSpotlights[$i]['image']) : $defaultSpotlights[$i]['image'];
                        $subtitle = $item ? ($item->link_text ?: $defaultSpotlights[$i]['subtitle']) : $defaultSpotlights[$i]['subtitle'];
                        $title = $item ? ($item->title ?: $defaultSpotlights[$i]['title']) : $defaultSpotlights[$i]['title'];
                        $desc = $item ? ($item->description ?: $defaultSpotlights[$i]['desc']) : $defaultSpotlights[$i]['desc'];
                        $link = $item ? ($item->link_url ?: $defaultSpotlights[$i]['link']) : $defaultSpotlights[$i]['link'];
                    @endphp

                    <div class="bg-white border border-stone-200/80 hover:border-[#a28e46]/60 rounded-sm p-4 sm:p-6 md:p-8 flex flex-col items-center text-center shadow-xs hover:shadow-xl transition-all duration-300 group">
                        <!-- Product Photo -->
                        <div class="w-full h-36 sm:h-44 md:h-52 flex items-center justify-center overflow-hidden mb-3 sm:mb-5">
                            <img src="{{ $img }}" alt="{{ $title }}"
                                class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                loading="lazy">
                        </div>

                        <!-- Subtitle -->
                        <span class="text-[#a28e46] text-[10px] sm:text-[11px] font-bold uppercase tracking-widest block mb-1.5">
                            {{ $subtitle }}
                        </span>

                        <!-- Title -->
                        <h4 class="font-serif text-xs sm:text-sm md:text-base font-bold text-gray-900 uppercase tracking-wide leading-snug mb-1.5 line-clamp-2">
                            <a href="{{ $link }}" class="hover:text-[#a28e46] transition-colors no-underline text-inherit">
                                {{ $title }}
                            </a>
                        </h4>

                        <!-- Description (hidden on small mobile to prevent text clutter) -->
                        @if($desc)
                            <p class="hidden sm:block text-stone-500 text-xs font-normal italic leading-relaxed mb-4 line-clamp-2 max-w-[260px]">
                                {{ $desc }}
                            </p>
                        @endif

                        <!-- Shop Now Button -->
                        <div class="mt-2 sm:mt-auto pt-1">
                            <a href="{{ $link }}"
                                class="inline-block border border-stone-300 hover:border-[#a28e46] bg-white hover:bg-[#a28e46] text-stone-700 hover:!text-white rounded-full px-5 sm:px-8 py-1.5 sm:py-2 text-[10px] sm:text-xs font-bold uppercase tracking-wider transition-all duration-200 shadow-xs no-underline hover:shadow-md hover:-translate-y-0.5">
                                SHOP NOW
                            </a>
                        </div>
                    </div>
                @endfor

            </div>
        </div>
    </section>

    <!-- Video Collections / Vlogs Section -->
    @if(!empty($vlogs) && count($vlogs) > 0)
        <section class="py-6 sm:py-10 bg-[#faf9f6] border-t border-stone-200/60">
            <div class="container mx-auto px-3 sm:px-4 max-w-7xl">
                <div class="flex items-center justify-between pb-2.5 sm:pb-3.5 mb-4 sm:mb-6 border-b border-stone-200">
                    <div class="relative">
                        <h2 class="text-sm sm:text-base md:text-2xl font-serif font-bold text-gray-900 uppercase tracking-wide m-0">
                            COLLECTIONS & VLOGS
                        </h2>
                        <span class="absolute -bottom-[11px] sm:-bottom-[15px] left-0 w-12 sm:w-16 h-[2px] bg-[#a28e46]"></span>
                    </div>
                    <a href="{{ route('vlogs') }}"
                        class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-[#a28e46] transition-colors no-underline flex items-center gap-1">
                        <span>View All</span>
                        <i class="fa-solid fa-arrow-right text-[9px]"></i>
                    </a>
                </div>

                <div id="vlogSplide" class="splide" aria-label="Collections and Vlogs">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach($vlogs as $vlog)
                                <li class="splide__slide">
                                    <div class="rounded-sm md:rounded-md overflow-hidden shadow-sm bg-white border border-stone-200/80">
                                        <div class="aspect-video w-full">
                                            {!! $vlog->frame_code !!}
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-6 right-6 z-50 flex flex-col gap-2.5 pointer-events-none"></div>

@endsection