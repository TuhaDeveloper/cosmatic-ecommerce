@extends('ecommerce.master')

@if(!empty($banners) && count($banners) > 0 && isset($banners[0]->image_url))
    @push('head')
        <link rel="preload" as="image" href="{{ $banners[0]->image_url }}" fetchpriority="high">
    @endpush
@endif

@section('main-section')
    <!-- 1. Full-Width Hero Banner Slider -->
    <section class="bg-[#faf9f6] py-3 md:py-6 border-b border-stone-200/60">
        <div class="container mx-auto px-3 sm:px-4 max-w-7xl">
            <div class="w-full">
                @php
                    $bannerList = !empty($banners) && count($banners) > 0 ? $banners : [];
                    $hasMultipleBanners = count($bannerList) > 1;
                @endphp

                @if($hasMultipleBanners)
                    <div id="heroSplide" class="splide rounded-sm overflow-hidden shadow-sm bg-white min-h-[180px] sm:min-h-[280px] md:min-h-[440px]" aria-label="Hero Banner">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach($bannerList as $index => $banner)
                                    <li class="splide__slide relative w-full bg-stone-100 flex items-center justify-center overflow-hidden">
                                        @if($banner->link_url)
                                            <a href="{{ $banner->link_url }}" class="block w-full">
                                                <img src="{{ $banner->image_url }}" alt="{{ $banner->title ?? 'Hero Banner' }}" class="w-full h-auto max-h-[520px] object-contain sm:object-cover block" @if($index === 0) fetchpriority="high" loading="eager" decoding="sync" @else loading="lazy" @endif>
                                            </a>
                                        @else
                                            <img src="{{ $banner->image_url }}" alt="{{ $banner->title ?? 'Hero Banner' }}" class="w-full h-auto max-h-[520px] object-contain sm:object-cover block" @if($index === 0) fetchpriority="high" loading="eager" decoding="sync" @else loading="lazy" @endif>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @elseif(count($bannerList) === 1)
                    @php $singleBanner = $bannerList[0]; @endphp
                    <div class="rounded-sm overflow-hidden shadow-sm bg-white w-full flex items-center justify-center">
                        @if($singleBanner->link_url)
                            <a href="{{ $singleBanner->link_url }}" class="block w-full">
                                <img src="{{ $singleBanner->image_url }}" alt="{{ $singleBanner->title ?? 'Hero Banner' }}" class="w-full h-auto max-h-[520px] object-contain sm:object-cover block" fetchpriority="high" loading="eager" decoding="sync">
                            </a>
                        @else
                            <img src="{{ $singleBanner->image_url }}" alt="{{ $singleBanner->title ?? 'Hero Banner' }}" class="w-full h-auto max-h-[520px] object-contain sm:object-cover block" fetchpriority="high" loading="eager" decoding="sync">
                        @endif
                    </div>
                @else
                    <!-- Default Beauty Hero Slide -->
                    <div class="rounded-sm overflow-hidden shadow-sm bg-[#f5ede3] min-h-[180px] sm:min-h-[280px] md:min-h-[440px] relative flex items-center">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#fbf8f3] via-[#f7f0e4] to-transparent z-0"></div>
                        <div class="container mx-auto px-4 md:px-12 relative z-10 flex flex-col items-end text-right ml-auto">
                            <div class="max-w-md">
                                <span class="text-[#a28e46] text-[10px] md:text-sm font-semibold uppercase tracking-widest block mb-1">Cosmetics & Spa</span>
                                <h1 class="font-serif text-xl sm:text-3xl md:text-5xl font-bold text-[#a28e46] italic leading-tight mb-1">
                                    The Body Care
                                </h1>
                                <h3 class="text-gray-500 font-sans text-xs sm:text-sm md:text-lg font-light tracking-widest uppercase mb-3 sm:mb-6">
                                    FRUIT FACE PACK
                                </h3>
                                <a href="{{ route('product.archive') }}" class="inline-flex items-center gap-2 border-2 border-[#a28e46] text-[#a28e46] hover:bg-[#a28e46] hover:text-white font-semibold text-[10px] sm:text-xs tracking-widest uppercase px-4 py-1.5 sm:px-7 sm:py-2.5 rounded-full transition-all duration-300 no-underline">
                                    SHOP NOW
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- 2. Popular Featured Categories Showcase (Pure White Canvas) -->
    @if(isset($featuredCategories) && count($featuredCategories) > 0)
    <section class="py-8 md:py-16 bg-white border-b border-stone-200/50">
        <div class="container mx-auto px-3 sm:px-4 max-w-7xl">
            <div class="flex items-center justify-between pb-3.5 mb-6 md:mb-8 border-b border-stone-200/80">
                <div class="relative">
                    <h2 class="text-lg md:text-2xl font-serif font-bold text-gray-900 uppercase tracking-wide">
                        FEATURED CATEGORIES
                    </h2>
                    <span class="absolute -bottom-[15px] left-0 w-16 h-[2px] bg-[#a28e46]"></span>
                </div>
                <a href="{{ route('categories') }}" class="text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-[#a28e46] transition-colors no-underline">
                    View All <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                </a>
            </div>

            <div id="categorySplide" class="splide" aria-label="Category Carousel">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($featuredCategories as $category)
                        <li class="splide__slide">
                            <a href="{{ route('product.archive') }}?category={{ $category->slug }}" class="group block relative aspect-[3/4] sm:aspect-[4/5] md:aspect-auto md:h-76 rounded-sm overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 no-underline">
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/25 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-3 sm:p-5 text-white flex flex-col items-start">
                                    <span class="font-serif font-bold text-sm sm:text-base md:text-lg uppercase tracking-wider mb-1 group-hover:text-[#f3e9cf] transition-colors leading-tight truncate w-full">{{ $category->name }}</span>
                                    <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-[#a28e46] bg-white px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-none flex items-center gap-1 mt-0.5 shadow-sm">
                                        Shop Now <i class="fa-solid fa-chevron-right text-[7px]"></i>
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

    <!-- 3. Promotional 2-Column Banners (Warm Off-White Canvas with Luxury Light-Sweep) -->
    <section class="py-6 md:py-14 bg-[#faf9f6] border-b border-stone-200/60">
        <div class="container mx-auto px-3 sm:px-4 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-8">
                @php
                    $b1 = $vlogBottomBanners[0] ?? null;
                    $b2 = $vlogBottomBanners[1] ?? null;
                @endphp

                <!-- Column 1 Banner (Full Image) -->
                <div class="w-full overflow-hidden rounded-sm">
                    @if($b1 && $b1->image_url)
                        <a href="{{ $b1->link_url ?? route('product.archive') }}" class="harosa-banner-box w-full block">
                            <img src="{{ $b1->image_url }}" alt="{{ $b1->title ?? 'Promotion Banner 1' }}" class="w-full h-auto block object-contain">
                        </a>
                    @else
                        <a href="{{ route('product.archive') }}" class="harosa-banner-box w-full block">
                            <img src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&auto=format&fit=crop&q=80" alt="Skin & Body Care" class="w-full h-auto block object-contain">
                        </a>
                    @endif
                </div>

                <!-- Column 2 Banner (Full Image) -->
                <div class="w-full overflow-hidden rounded-sm">
                    @if($b2 && $b2->image_url)
                        <a href="{{ $b2->link_url ?? route('product.archive') }}" class="harosa-banner-box w-full block">
                            <img src="{{ $b2->image_url }}" alt="{{ $b2->title ?? 'Promotion Banner 2' }}" class="w-full h-auto block object-contain">
                        </a>
                    @else
                        <a href="{{ route('product.archive') }}" class="harosa-banner-box w-full block">
                            <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=800&auto=format&fit=crop&q=80" alt="Organic Creams" class="w-full h-auto block object-contain">
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Signature Tabbed Products Showcase (Pure White Canvas with Hover Add to Cart) -->
    <section class="py-14 md:py-20 bg-white border-b border-stone-200/50">
        <div class="container mx-auto px-4 max-w-7xl">
            
            <!-- Tab Navigation Header -->
            <div class="flex items-center justify-center gap-6 md:gap-12 pb-10 text-center flex-wrap">
                <button type="button" class="harosa-tab-btn active text-xs md:text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-[#a28e46] transition-colors flex items-center gap-2 cursor-pointer pb-1.5 border-b-2 border-transparent focus:outline-none" data-tab-target="tab-new-arrivals">
                    <span class="w-2 h-2 rounded-full bg-[#a28e46] inline-block"></span>
                    <span>NEW ARRIVAL</span>
                </button>

                <button type="button" class="harosa-tab-btn text-xs md:text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-[#a28e46] transition-colors flex items-center gap-2 cursor-pointer pb-1.5 border-b-2 border-transparent focus:outline-none" data-tab-target="tab-bestseller">
                    <span class="w-2 h-2 rounded-full bg-gray-300 inline-block dot-indicator"></span>
                    <span>BESTSELLER</span>
                </button>

                <button type="button" class="harosa-tab-btn text-xs md:text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-[#a28e46] transition-colors flex items-center gap-2 cursor-pointer pb-1.5 border-b-2 border-transparent focus:outline-none" data-tab-target="tab-featured">
                    <span class="w-2 h-2 rounded-full bg-gray-300 inline-block dot-indicator"></span>
                    <span>FEATURED PRODUCTS</span>
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

    <!-- 5. Trending Deals & Weekly Special Offers (Warm Off-White Canvas) -->
    <section class="py-12 md:py-18 bg-[#faf9f6] border-b border-stone-200/60">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex items-center justify-between pb-3.5 mb-8 border-b border-stone-200/80">
                <div class="relative">
                    <h2 class="text-lg md:text-2xl font-serif font-bold text-gray-900 uppercase tracking-wide">
                        WEEKLY SPECIAL OFFERS
                    </h2>
                    <span class="absolute -bottom-[15px] left-0 w-16 h-[2px] bg-[#a28e46]"></span>
                </div>
                <a href="{{ route('best.deal') }}" class="text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-[#a28e46] transition-colors no-underline">
                    View All Offers <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                </a>
            </div>

            <div id="weeklyDealsSplide" class="splide" aria-label="Weekly Best Deals" style="visibility:hidden;">
                <div class="splide__track">
                    <ul class="splide__list" id="weeklyDealsSplideList"></ul>
                </div>
            </div>
            <div id="weeklyDealsFallback" class="grid grid-cols-2 md:grid-cols-4 gap-6"></div>
        </div>
    </section>

    <!-- 6. 3-Column Luxury Feature Spotlight (Pure White Canvas) -->
    <section class="py-14 md:py-20 bg-white border-b border-stone-200/50">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                @php
                    $defaultSpotlights = [
                        [
                            'image' => 'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=600&auto=format&fit=crop&q=80',
                            'subtitle' => 'SALE 30% OFF',
                            'title' => 'NSI BALANCE GEL BODY BUILDER NUDE',
                            'desc' => 'Praesent volutpat ut nisl in hendrerit. Vestibulum ante ipsum primis in faucibus.',
                            'link' => route('product.archive'),
                        ],
                        [
                            'image' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=600&auto=format&fit=crop&q=80',
                            'subtitle' => 'SALE 50% OFF',
                            'title' => 'BUY NUDE BY BILL BLASS FOR HER EDC 100 ML',
                            'desc' => 'Praesent volutpat ut nisl in hendrerit. Vestibulum ante ipsum primis in faucibus.',
                            'link' => route('product.archive'),
                        ],
                        [
                            'image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=600&auto=format&fit=crop&q=80',
                            'subtitle' => 'SALE 20% OFF',
                            'title' => 'PBM CREAM FOUNDATION MAKEUP',
                            'desc' => 'Praesent volutpat ut nisl in hendrerit. Vestibulum ante ipsum primis in faucibus.',
                            'link' => route('product.archive'),
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
                    
                    <div class="bg-white border border-stone-200/80 rounded-sm p-6 md:p-8 flex flex-col items-center text-center shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <!-- Product Photo (Rock-Solid Anti-Jitter Image Container) -->
                        <a href="{{ $link }}" class="w-full aspect-[4/3] overflow-hidden mb-5 bg-stone-50 rounded-sm block group/img relative">
                            <img src="{{ $img }}" alt="{{ $title }}" class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-500 ease-out block pointer-events-none select-none" loading="lazy">
                        </a>

                        <!-- Subtitle -->
                        <span class="text-[#a28e46] text-[11px] font-bold uppercase tracking-widest block mb-2">
                            {{ $subtitle }}
                        </span>

                        <!-- Title -->
                        <h4 class="font-serif text-sm md:text-base font-bold text-gray-900 uppercase tracking-wide leading-snug mb-2 line-clamp-2">
                            <a href="{{ $link }}" class="hover:text-[#a28e46] transition-colors no-underline text-inherit">
                                {{ $title }}
                            </a>
                        </h4>

                        <!-- Description -->
                        <p class="text-stone-500 text-xs font-normal italic leading-relaxed mb-6 line-clamp-2 max-w-[260px]">
                            {{ $desc }}
                        </p>

                        <!-- Shop Now Button (Solid Gold Theme with White Text) -->
                        <div class="mt-auto">
                            <a href="{{ $link }}" class="inline-flex items-center justify-center bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-wider rounded-full px-8 py-2.5 transition-all duration-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 no-underline">
                                SHOP NOW
                            </a>
                        </div>
                    </div>
                @endfor

            </div>
        </div>
    </section>

    <!-- 6. Collections & Video Vlogs Section (Pure White Canvas) -->
    @if(!empty($vlogs) && count($vlogs) > 0)
    <section class="py-12 md:py-18 bg-white border-b border-stone-200/50">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex items-center justify-between pb-3.5 mb-8 border-b border-stone-200/80">
                <div class="relative">
                    <h2 class="text-xl md:text-2xl font-serif font-bold text-gray-900 uppercase tracking-wide">
                        COLLECTIONS & VLOGS
                    </h2>
                    <span class="absolute -bottom-[15px] left-0 w-16 h-[2px] bg-[#a28e46]"></span>
                </div>
                <a href="{{ route('vlogs') }}" class="text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-[#a28e46] transition-colors no-underline">
                    View All <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                </a>
            </div>

            <div id="vlogSplide" class="splide" aria-label="Collections and Vlogs">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($vlogs as $vlog)
                            <li class="splide__slide">
                                <div class="rounded-sm overflow-hidden shadow-md bg-white border border-stone-200/80">
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