@extends('ecommerce.master')

@php
    $settings = $general_settings;
    $avgRating = $product->averageRating() ?: 5;
    $totalReviews = $product->totalReviews() ?: 0;
    $effectivePrice = $product->effective_price;
    $price = (float)$product->price;
    $hasDiscount = $effectivePrice < $price;
    $discountPercent = $price > 0 && $hasDiscount ? round((($price - $effectivePrice) / $price) * 100) : 0;
    $inStock = $product->has_variations ? ($product->variations->sum(fn($v) => $v->stocks->sum('quantity')) > 0) : ($product->stock > 0 || $product->manage_stock == false);
@endphp

@section('main-section')
<div class="bg-stone-50/60 min-h-screen pb-16">

    <!-- 1. Breadcrumbs -->
    <div class="bg-white border-b border-stone-200/60 py-3.5">
        <div class="container mx-auto px-4 max-w-7xl">
            <nav class="flex items-center gap-2 text-xs text-stone-500 flex-wrap" aria-label="Breadcrumb">
                <a href="/" class="hover:text-[#a28e46] transition-colors no-underline">Home</a>
                <span class="text-stone-300">/</span>
                @if($product->category)
                    <a href="{{ route('product.archive') }}?category={{ $product->category->slug }}" class="hover:text-[#a28e46] transition-colors no-underline">
                        {{ $product->category->name }}
                    </a>
                    <span class="text-stone-300">/</span>
                @endif
                <span class="text-stone-800 font-medium truncate max-w-xs md:max-w-md">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- 2. Main Product Showcase Section -->
    <section class="py-3 sm:py-6 lg:py-10">
        <div class="container mx-auto px-3 sm:px-4 max-w-7xl">
            <div class="bg-white rounded-xl sm:rounded-sm border border-stone-200/80 shadow-xs sm:shadow-sm p-3.5 sm:p-6 lg:p-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-8 lg:gap-12 items-start">
                    
                    <!-- Left: Gallery Showcase (Cols 6) -->
                    <div class="lg:col-span-6 space-y-3 sm:space-y-4">
                        <!-- Main Image Stage with Fluid Magnifier Lens -->
                        <div id="mainImgContainer" class="relative aspect-square w-full bg-stone-50/60 rounded-lg sm:rounded-sm border border-stone-200/80 overflow-hidden group cursor-crosshair">
                            <!-- Floating Badges -->
                            <div class="absolute top-2.5 left-2.5 sm:top-3 sm:left-3 flex flex-col gap-1 z-10 pointer-events-none">
                                @if($discountPercent > 0)
                                    <span class="bg-[#222222] text-white text-[10px] sm:text-[11px] font-bold px-2 py-0.5 sm:px-2.5 sm:py-1 uppercase tracking-wider rounded-sm shadow-xs">
                                        -{{ $discountPercent }}% OFF
                                    </span>
                                @endif
                                <span class="bg-[#a28e46] text-white text-[9px] sm:text-[10px] font-bold px-2 py-0.5 sm:px-2.5 sm:py-0.5 uppercase tracking-wider rounded-sm shadow-xs">
                                    AUTHENTIC
                                </span>
                            </div>

                            <!-- Floating Wishlist Button -->
                            <button type="button" 
                                    class="wishlist-btn absolute top-2.5 right-2.5 sm:top-3 sm:right-3 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white/95 hover:bg-white text-stone-700 shadow-sm sm:shadow-md flex items-center justify-center transition-all duration-200 z-10 cursor-pointer focus:outline-none {{ $product->is_wishlisted ? 'active text-red-500' : '' }}"
                                    data-product-id="{{ $product->id }}"
                                    aria-label="Save to Wishlist">
                                <i class="{{ $product->is_wishlisted ? 'fa-solid fa-heart text-red-500' : 'fa-regular fa-heart' }} text-xs sm:text-base"></i>
                            </button>

                            <!-- Magnifier Hint on Hover (Desktop) -->
                            <span class="hidden md:flex absolute bottom-3 right-3 items-center gap-1.5 bg-black/60 text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10">
                                <i class="fa-solid fa-magnifying-glass-plus text-xs"></i> Zoom
                            </span>

                            <!-- Main Image Display -->
                            <img id="mainProductImg" 
                                 src="{{ asset($product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-contain p-2 sm:p-4 transition-transform duration-200 pointer-events-none select-none origin-center"
                                 loading="eager" 
                                 onerror="this.onerror=null; this.src='/static/default-product.jpg';">
                        </div>

                        <!-- Gallery Thumbnails -->
                        @php
                            $allImages = [];
                            if ($product->image) $allImages[] = asset($product->image);
                            foreach ($product->galleries as $g) {
                                if ($g->image) $allImages[] = asset($g->image);
                            }
                        @endphp

                        @if(count($allImages) > 1)
                        <div class="flex items-center gap-2 sm:gap-3 overflow-x-auto pb-1.5 scrollbar-thin" id="pdGalleryThumbs">
                            @foreach($allImages as $idx => $imgUrl)
                                <button type="button" 
                                        class="pd-thumb-btn w-14 h-14 sm:w-20 sm:h-20 flex-shrink-0 bg-stone-50 rounded-md sm:rounded-sm border-2 overflow-hidden transition-all duration-200 p-0.5 sm:p-1 cursor-pointer focus:outline-none {{ $idx === 0 ? 'border-[#a28e46] shadow-xs' : 'border-stone-200 hover:border-stone-300 opacity-70 hover:opacity-100' }}"
                                        onclick="switchMainProductImage('{{ $imgUrl }}', this)">
                                    <img src="{{ $imgUrl }}" alt="Thumb {{ $idx + 1 }}" class="w-full h-full object-contain">
                                </button>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- Right: Product Info & Purchase Actions (Cols 6) -->
                    <div class="lg:col-span-6 space-y-3.5 sm:space-y-5">
                        
                        <!-- Top Tags & SKU -->
                        <div class="flex items-center justify-between gap-2 text-[11px] sm:text-xs text-stone-400 font-medium flex-wrap">
                            <div class="flex items-center gap-1.5">
                                @if($product->brand)
                                    <span class="text-[#a28e46] uppercase font-bold tracking-wider">{{ $product->brand->name }}</span>
                                    <span class="text-stone-300">•</span>
                                @endif
                                @if($product->category)
                                    <span class="uppercase tracking-wider text-stone-500">{{ $product->category->name }}</span>
                                @endif
                            </div>
                            <span class="font-mono text-stone-400 text-[11px] sm:text-xs" id="pdSkuDisplay">SKU: {{ $product->sku ?? 'N/A' }}</span>
                        </div>

                        <!-- Product Title -->
                        <h1 class="font-serif text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 leading-tight tracking-tight uppercase">
                            {{ $product->name }}
                        </h1>

                        <!-- Ratings & Reviews Summary -->
                        <div class="flex items-center gap-2 sm:gap-3 py-1.5 border-y border-stone-100">
                            <div class="flex items-center text-amber-400 text-[11px] sm:text-xs gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($avgRating))
                                        <i class="fa-solid fa-star"></i>
                                    @elseif($i - $avgRating < 1)
                                        <i class="fa-solid fa-star-half-stroke"></i>
                                    @else
                                        <i class="fa-regular fa-star text-stone-300"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-stone-700 font-bold">{{ number_format($avgRating, 1) }}</span>
                            <span class="text-xs text-stone-400">({{ $totalReviews }} {{ Str::plural('review', $totalReviews) }})</span>
                            <a href="#productReviewsTab" onclick="switchToReviewsTab()" class="text-xs text-[#a28e46] hover:underline font-medium no-underline ml-auto">
                                Write a review
                            </a>
                        </div>

                        <!-- Price Showcase -->
                        <div class="flex items-baseline gap-2.5 sm:gap-3.5 py-0.5 flex-wrap">
                            <span id="pdPriceDisplay" class="font-serif text-2xl sm:text-3xl lg:text-3.5xl font-bold text-[#a28e46] tracking-tight">
                                ৳ {{ number_format($effectivePrice) }}
                            </span>
                            @if($hasDiscount)
                                <span id="pdOriginalPriceDisplay" class="text-stone-400 line-through text-sm sm:text-base font-normal">
                                    ৳ {{ number_format($price) }}
                                </span>
                                <span id="pdSaveBadge" class="bg-rose-50 text-rose-600 text-[10px] sm:text-xs font-bold px-2 py-0.5 rounded border border-rose-200 uppercase tracking-wider">
                                    Save ৳{{ number_format($price - $effectivePrice) }} ({{ $discountPercent }}% OFF)
                                </span>
                            @else
                                <span id="pdOriginalPriceDisplay" class="text-stone-400 line-through text-sm sm:text-base font-normal hidden"></span>
                                <span id="pdSaveBadge" class="bg-rose-50 text-rose-600 text-[10px] sm:text-xs font-bold px-2 py-0.5 rounded border border-rose-200 uppercase tracking-wider hidden"></span>
                            @endif
                        </div>

                        <!-- Short Description -->
                        @if($product->short_desc)
                            <div class="text-stone-600 text-xs sm:text-sm leading-relaxed border-b border-stone-100 pb-3">
                                {!! $product->short_desc !!}
                            </div>
                        @endif

                        <!-- Variations Section (Attributes Selection) -->
                        @if($product->has_variations && count($attributeGroups) > 0)
                        <div class="space-y-3 pt-0.5 border-b border-stone-100 pb-4" id="pdVariationsWrap">
                            @foreach($attributeGroups as $attrId => $attrGroup)
                                <div class="space-y-1.5">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="font-bold text-stone-800 uppercase tracking-wider">
                                            Select {{ $attrGroup['name'] }}:
                                        </span>
                                        <span class="text-stone-500 font-semibold" id="selectedLabel_{{ $attrId }}"></span>
                                    </div>

                                    <div class="flex flex-wrap gap-2" data-attr-id="{{ $attrId }}">
                                        @foreach($attrGroup['values'] as $valId => $val)
                                            <button type="button" 
                                                    class="pd-attr-option min-w-[42px] h-9 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider rounded-md border transition-all cursor-pointer focus:outline-none bg-white text-stone-700 border-stone-300 hover:border-stone-400 active:scale-95 flex items-center justify-center shadow-xs"
                                                    data-attr-id="{{ $attrId }}" 
                                                    data-value-id="{{ $valId }}" 
                                                    data-value-label="{{ $val['label'] }}"
                                                    onclick="selectProductAttribute({{ $attrId }}, {{ $valId }}, '{{ $val['label'] }}')">
                                                {{ $val['label'] }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- Quantity Stepper & Stock Status -->
                        <div class="flex items-center justify-between gap-3 pt-0.5">
                            <div class="flex items-center gap-2.5">
                                <span class="text-xs font-bold text-stone-800 uppercase tracking-wider">Quantity:</span>
                                <div class="inline-flex items-center border border-stone-300 rounded-lg bg-white overflow-hidden shadow-xs h-8 sm:h-9">
                                    <button type="button" class="w-8 sm:w-9 h-full flex items-center justify-center text-stone-600 hover:bg-stone-100 active:bg-stone-200 transition-colors focus:outline-none cursor-pointer" onclick="changeProductQty(-1)">
                                        <i class="fa-solid fa-minus text-[10px] sm:text-xs"></i>
                                    </button>
                                    <input type="text" id="pdQuantityInput" value="1" readonly class="w-9 sm:w-11 h-full text-center text-xs sm:text-sm font-bold text-stone-800 border-x border-stone-300 outline-none bg-transparent">
                                    <button type="button" class="w-8 sm:w-9 h-full flex items-center justify-center text-stone-600 hover:bg-stone-100 active:bg-stone-200 transition-colors focus:outline-none cursor-pointer" onclick="changeProductQty(1)">
                                        <i class="fa-solid fa-plus text-[10px] sm:text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="pdStockIndicator" class="text-xs font-medium flex items-center gap-1.5 {{ $inStock ? 'text-emerald-600' : 'text-rose-500' }}">
                                <i class="fa-solid fa-circle text-[7px]"></i>
                                <span class="text-[11px] sm:text-xs">{{ $inStock ? 'In Stock (Ready to Ship)' : 'Out of Stock' }}</span>
                            </div>
                        </div>

                        <!-- Dual Action Buttons (2-col on mobile for compact height) -->
                        <div class="grid grid-cols-2 gap-2.5 sm:gap-3.5 pt-1.5">
                            <!-- Button 1: Add to Cart (Solid Gold) -->
                            <button type="button" 
                                    id="pdAddToCartBtn"
                                    class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-wider py-3 sm:py-3.5 px-3 rounded-lg shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-1.5 cursor-pointer focus:outline-none active:scale-[0.98] {{ !$inStock ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    onclick="executeAddToCart(false)">
                                <i class="fa-solid fa-bag-shopping text-xs"></i>
                                <span>ADD TO BAG</span>
                            </button>

                            <!-- Button 2: Buy Now (Instant Checkout) -->
                            <button type="button" 
                                    id="pdBuyNowBtn"
                                    class="w-full bg-[#222222] hover:bg-black text-white font-bold text-xs uppercase tracking-wider py-3 sm:py-3.5 px-3 rounded-lg shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-1.5 cursor-pointer focus:outline-none active:scale-[0.98] {{ !$inStock ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    onclick="executeAddToCart(true)">
                                <i class="fa-solid fa-bolt text-xs text-[#a28e46]"></i>
                                <span>BUY IT NOW</span>
                            </button>
                        </div>

                        <!-- 4 Pillars Trust Badges (Compact & clean) -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3 pt-3 border-t border-stone-100 text-center">
                            <div class="p-2 sm:p-3 bg-stone-50/80 rounded-lg border border-stone-200/60 flex flex-col items-center justify-center gap-0.5 sm:gap-1">
                                <i class="fa-solid fa-truck-fast text-[#a28e46] text-sm sm:text-base"></i>
                                <span class="text-[9px] sm:text-[10px] font-bold text-stone-700 uppercase tracking-wider">Fast Delivery</span>
                            </div>
                            <div class="p-2 sm:p-3 bg-stone-50/80 rounded-lg border border-stone-200/60 flex flex-col items-center justify-center gap-0.5 sm:gap-1">
                                <i class="fa-solid fa-shield-halved text-[#a28e46] text-sm sm:text-base"></i>
                                <span class="text-[9px] sm:text-[10px] font-bold text-stone-700 uppercase tracking-wider">100% Authentic</span>
                            </div>
                            <div class="p-2 sm:p-3 bg-stone-50/80 rounded-lg border border-stone-200/60 flex flex-col items-center justify-center gap-0.5 sm:gap-1">
                                <i class="fa-solid fa-rotate-left text-[#a28e46] text-sm sm:text-base"></i>
                                <span class="text-[9px] sm:text-[10px] font-bold text-stone-700 uppercase tracking-wider">Easy Returns</span>
                            </div>
                            <div class="p-2 sm:p-3 bg-stone-50/80 rounded-lg border border-stone-200/60 flex flex-col items-center justify-center gap-0.5 sm:gap-1">
                                <i class="fa-solid fa-lock text-[#a28e46] text-sm sm:text-base"></i>
                                <span class="text-[9px] sm:text-[10px] font-bold text-stone-700 uppercase tracking-wider">Secure Payment</span>
                            </div>
                        </div>

                        <!-- Share & Social Buttons -->
                        <div class="flex items-center gap-2 pt-1 text-xs text-stone-500 flex-wrap">
                            <span class="font-bold uppercase tracking-wider text-stone-700 text-[11px]">Share:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-stone-100 hover:bg-[#a28e46] hover:text-white flex items-center justify-center transition-colors no-underline text-stone-600">
                                <i class="fa-brands fa-facebook-f text-[10px]"></i>
                            </a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($product->name . ' - ' . request()->fullUrl()) }}" target="_blank" class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-stone-100 hover:bg-[#a28e46] hover:text-white flex items-center justify-center transition-colors no-underline text-stone-600">
                                <i class="fa-brands fa-whatsapp text-[10px]"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($product->name) }}" target="_blank" class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-stone-100 hover:bg-[#a28e46] hover:text-white flex items-center justify-center transition-colors no-underline text-stone-600">
                                <i class="fa-brands fa-x-twitter text-[10px]"></i>
                            </a>
                            <button type="button" onclick="copyProductLink()" class="px-2 py-0.5 rounded bg-stone-100 hover:bg-[#a28e46] hover:text-white text-[10px] sm:text-[11px] font-semibold transition-colors focus:outline-none flex items-center gap-1 cursor-pointer">
                                <i class="fa-solid fa-link text-[9px]"></i> Copy Link
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Comprehensive Product Information Tabs Section -->
    <section class="py-4 sm:py-8">
        <div class="container mx-auto px-3 sm:px-4 max-w-7xl">
            <div class="bg-white rounded-xl sm:rounded-sm border border-stone-200/80 shadow-xs sm:shadow-sm overflow-hidden">
                
                <!-- Tab Headers -->
                <div class="flex items-center gap-2 sm:gap-8 px-3 sm:px-8 border-b border-stone-200 overflow-x-auto bg-stone-50/50 scrollbar-none">
                    <button type="button" class="pd-tab-btn active py-3 sm:py-4 text-xs sm:text-sm font-bold uppercase tracking-wider text-stone-400 hover:text-[#a28e46] border-b-2 border-transparent transition-all focus:outline-none cursor-pointer flex items-center gap-2 flex-shrink-0" data-target="tab-desc">
                        <span>Description</span>
                    </button>
                    <button type="button" class="pd-tab-btn py-3 sm:py-4 text-xs sm:text-sm font-bold uppercase tracking-wider text-stone-400 hover:text-[#a28e46] border-b-2 border-transparent transition-all focus:outline-none cursor-pointer flex items-center gap-2 flex-shrink-0" data-target="tab-specs">
                        <span>Specifications</span>
                    </button>
                    <button type="button" id="productReviewsTab" class="pd-tab-btn py-3 sm:py-4 text-xs sm:text-sm font-bold uppercase tracking-wider text-stone-400 hover:text-[#a28e46] border-b-2 border-transparent transition-all focus:outline-none cursor-pointer flex items-center gap-2 flex-shrink-0" data-target="tab-reviews">
                        <span>Reviews ({{ $totalReviews }})</span>
                    </button>
                    <button type="button" class="pd-tab-btn py-3 sm:py-4 text-xs sm:text-sm font-bold uppercase tracking-wider text-stone-400 hover:text-[#a28e46] border-b-2 border-transparent transition-all focus:outline-none cursor-pointer flex items-center gap-2 flex-shrink-0" data-target="tab-shipping">
                        <span>Shipping</span>
                    </button>
                </div>

                <!-- Tab Panes -->
                <div class="p-4 sm:p-8 lg:p-10">
                    
                    <!-- Pane 1: Full Description -->
                    <div id="tab-desc" class="pd-tab-pane block space-y-4">
                        <div class="prose max-w-none text-stone-700 text-xs sm:text-sm leading-relaxed">
                            {!! $product->description ?: '<p class="text-stone-400 italic">No detailed description available for this product.</p>' !!}
                        </div>
                        @if($product->features)
                            <div class="mt-4 pt-4 border-t border-stone-100">
                                <h4 class="font-serif font-bold text-sm sm:text-base text-stone-900 uppercase tracking-wider mb-2 sm:mb-3">Key Features & Benefits</h4>
                                <div class="prose max-w-none text-stone-700 text-xs sm:text-sm leading-relaxed">
                                    {!! $product->features !!}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Pane 2: Specifications Table -->
                    <div id="tab-specs" class="pd-tab-pane hidden">
                        <div class="max-w-2xl">
                            <table class="w-full text-xs sm:text-sm border border-stone-200">
                                <tbody class="divide-y divide-stone-200">
                                    <tr class="bg-stone-50">
                                        <td class="px-3.5 py-2 sm:px-4 sm:py-2.5 font-bold text-stone-700 w-1/3">Product Name</td>
                                        <td class="px-3.5 py-2 sm:px-4 sm:py-2.5 text-stone-600">{{ $product->name }}</td>
                                    </tr>
                                    @if($product->brand)
                                    <tr>
                                        <td class="px-3.5 py-2 sm:px-4 sm:py-2.5 font-bold text-stone-700">Brand</td>
                                        <td class="px-3.5 py-2 sm:px-4 sm:py-2.5 text-stone-600">{{ $product->brand->name }}</td>
                                    </tr>
                                    @endif
                                    @if($product->category)
                                    <tr class="bg-stone-50">
                                        <td class="px-3.5 py-2 sm:px-4 sm:py-2.5 font-bold text-stone-700">Category</td>
                                        <td class="px-3.5 py-2 sm:px-4 sm:py-2.5 text-stone-600">{{ $product->category->name }}</td>
                                    </tr>
                                    @endif
                                    @if($product->sku)
                                    <tr>
                                        <td class="px-3.5 py-2 sm:px-4 sm:py-2.5 font-bold text-stone-700">SKU Code</td>
                                        <td class="px-3.5 py-2 sm:px-4 sm:py-2.5 text-stone-600">{{ $product->sku }}</td>
                                    </tr>
                                    @endif
                                    @if($product->unit)
                                    <tr class="bg-stone-50">
                                        <td class="px-3.5 py-2 sm:px-4 sm:py-2.5 font-bold text-stone-700">Unit / Volume</td>
                                        <td class="px-3.5 py-2 sm:px-4 sm:py-2.5 text-stone-600">{{ $product->unit->name ?? 'Standard' }}</td>
                                    </tr>
                                    @endif
                                    @if($product->gender)
                                    <tr>
                                        <td class="px-3.5 py-2 sm:px-4 sm:py-2.5 font-bold text-stone-700">Target Audience</td>
                                        <td class="px-3.5 py-2 sm:px-4 sm:py-2.5 text-stone-600">{{ $product->gender->name }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pane 3: Customer Reviews -->
                    <div id="tab-reviews" class="pd-tab-pane hidden space-y-6">
                        
                        <!-- Review Statistics Summary -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 sm:gap-6 items-center bg-stone-50 p-4 sm:p-6 rounded-lg border border-stone-200/80">
                            <div class="md:col-span-4 text-center md:border-r border-stone-200 pr-0 md:pr-4">
                                <span class="font-serif text-4xl sm:text-5xl font-bold text-stone-900 block mb-1">
                                    {{ number_format($avgRating, 1) }}
                                </span>
                                <div class="flex items-center justify-center text-amber-400 text-xs sm:text-sm gap-1 mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                </div>
                                <span class="text-xs text-stone-500 font-medium">Based on {{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}</span>
                            </div>

                            <div class="md:col-span-8 space-y-1.5">
                                @php $ratingDistribution = $product->getRatingDistribution(); @endphp
                                @for($star = 5; $star >= 1; $star--)
                                    @php 
                                        $count = $ratingDistribution[$star] ?? 0;
                                        $pct = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
                                    @endphp
                                    <div class="flex items-center gap-2.5 text-xs">
                                        <span class="w-12 text-stone-600 font-semibold">{{ $star }} Star</span>
                                        <div class="flex-grow h-2 bg-stone-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $pct }}%;"></div>
                                        </div>
                                        <span class="w-6 text-stone-400 text-right">{{ $count }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Reviews List -->
                        <div class="space-y-3">
                            <h4 class="font-serif font-bold text-sm sm:text-base text-stone-900 uppercase tracking-wider">
                                Customer Feedback ({{ $totalReviews }})
                            </h4>

                            @if($product->approvedReviews && count($product->approvedReviews) > 0)
                                <div class="divide-y divide-stone-100">
                                    @foreach($product->approvedReviews as $rev)
                                        <div class="py-3 sm:py-4 space-y-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-bold text-xs uppercase text-stone-800">{{ $rev->user->name ?? ($rev->name ?: 'Verified Customer') }}</span>
                                                <span class="text-[10px] sm:text-[11px] text-stone-400">{{ $rev->created_at ? $rev->created_at->format('M d, Y') : 'Recently' }}</span>
                                            </div>
                                            <div class="flex items-center text-amber-400 text-[10px] sm:text-xs gap-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="{{ $i <= $rev->rating ? 'fa-solid fa-star' : 'fa-regular fa-star text-stone-300' }}"></i>
                                                @endfor
                                            </div>
                                            <p class="text-xs sm:text-sm text-stone-600 leading-relaxed pt-0.5">
                                                {{ $rev->comment }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-xs text-stone-400 italic">No reviews yet. Be the first to review this product!</p>
                            @endif
                        </div>

                    </div>

                    <!-- Pane 4: Shipping & Returns -->
                    <div id="tab-shipping" class="pd-tab-pane hidden space-y-3 text-xs sm:text-sm text-stone-600 leading-relaxed">
                        <h4 class="font-serif font-bold text-sm sm:text-base text-stone-900 uppercase tracking-wider mb-2">Delivery & Return Policy</h4>
                        <p><strong>Inside Dhaka:</strong> Delivery within 24 to 48 hours. Standard home delivery charge applies.</p>
                        <p><strong>Outside Dhaka (Nationwide):</strong> Delivery within 2 to 4 business days via verified courier services.</p>
                        <p><strong>7 Days Return Policy:</strong> If you receive any damaged, incorrect, or defective cosmetics, please notify our customer care team within 7 days of receiving the parcel for a swift replacement or refund.</p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- 4. Related Products Showcase (YOU MAY ALSO LIKE) -->
    @if(isset($relatedProducts) && count($relatedProducts) > 0)
    <section class="py-5 sm:py-8 lg:py-12">
        <div class="container mx-auto px-3 sm:px-4 max-w-7xl">
            <!-- Section Header -->
            <div class="flex items-center justify-between pb-2.5 mb-4 sm:mb-6 border-b border-stone-200/80">
                <div class="relative">
                    <h2 class="text-base sm:text-xl md:text-2xl font-serif font-bold text-gray-900 uppercase tracking-wide">
                        YOU MAY ALSO LIKE
                    </h2>
                    <span class="absolute -bottom-[11px] sm:-bottom-[15px] left-0 w-12 sm:w-16 h-[2px] bg-[#a28e46]"></span>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('product.archive') }}?category={{ $product->category->slug ?? '' }}" class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-stone-500 hover:text-[#a28e46] transition-colors no-underline">
                        View More <i class="fa-solid fa-arrow-right text-[9px] sm:text-[10px] ml-0.5"></i>
                    </a>
                </div>
            </div>

            <!-- Standard Splide Carousel (Matching Home & Other Pages) -->
            <div id="relatedProductsSplide" class="splide" aria-label="Related Products">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($relatedProducts as $rel)
                            @php
                                $relEff = $rel->effective_price;
                                $relPrice = (float)$rel->price;
                                $relDisc = $relPrice > 0 && $relEff < $relPrice ? round((($relPrice - $relEff) / $relPrice) * 100) : 0;
                                $relCategory = $rel->category->name ?? 'Beauty';
                            @endphp
                            <li class="splide__slide">
                                <div class="group relative bg-white border border-stone-200/80 rounded-xl sm:rounded-sm overflow-hidden flex flex-col items-center text-center transition-all duration-300 hover:shadow-lg hover:border-[#a28e46]/40 h-full">
                                    <!-- Full-Bleed Product Image Stage (Edge-to-Edge) -->
                                    <div class="relative w-full aspect-[4/5] overflow-hidden bg-stone-100/50 group/img">
                                        <!-- Discount Tag -->
                                        @if($relDisc > 0)
                                            <span class="absolute top-2 left-2 bg-[#222222] text-white text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded-none uppercase tracking-wider z-10 shadow-xs">
                                                -{{ $relDisc }}%
                                            </span>
                                        @endif

                                        <a href="/product/{{ $rel->slug }}" class="block w-full h-full">
                                            <img src="{{ asset($rel->image) }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 block" 
                                                 alt="{{ $rel->name }}" 
                                                 loading="lazy" 
                                                 onerror="this.onerror=null; this.src='/static/default-product.jpg';">
                                        </a>

                                        <!-- Mobile 1-Tap Quick Add Floating Button -->
                                        <button type="button" 
                                                class="md:hidden absolute bottom-2 right-2 w-8 h-8 rounded-full bg-[#a28e46] active:bg-[#8e7b39] text-white shadow-md flex items-center justify-center text-xs z-20 cursor-pointer focus:outline-none transition-transform active:scale-95"
                                                onclick="event.stopPropagation(); handleQuickAddToCart({{ $rel->id }}, {{ $rel->has_variations ? 'true' : 'false' }}, '{{ $rel->slug }}');"
                                                aria-label="Add to cart">
                                            <i class="fa-solid fa-bag-shopping text-[11px]"></i>
                                        </button>

                                        <!-- Desktop Hover Quick Add Bar -->
                                        <div class="hidden md:flex absolute inset-x-0 bottom-0 p-2.5 bg-gradient-to-t from-black/70 via-black/30 to-transparent translate-y-full group-hover/img:translate-y-0 transition-transform duration-300 items-center justify-center z-20">
                                            <button type="button" 
                                                    class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-[11px] uppercase tracking-wider py-2 px-3 rounded-none shadow transition-all flex items-center justify-center gap-1.5 cursor-pointer focus:outline-none"
                                                    onclick="event.stopPropagation(); handleQuickAddToCart({{ $rel->id }}, {{ $rel->has_variations ? 'true' : 'false' }}, '{{ $rel->slug }}');">
                                                <i class="fa-solid fa-cart-shopping text-[10px]"></i>
                                                <span>ADD TO CART</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Product Information with clean internal padding -->
                                    <div class="w-full flex flex-col items-center text-center p-2.5 sm:p-3 mt-auto">
                                        <!-- Category Name -->
                                        <span class="text-[10px] sm:text-[11px] text-stone-400 font-medium truncate max-w-full block mb-1">
                                            {{ $relCategory }}
                                        </span>

                                        <!-- Product Name -->
                                        <a href="/product/{{ $rel->slug }}" class="font-serif text-xs sm:text-sm font-bold text-gray-900 hover:text-[#a28e46] uppercase tracking-wider text-center block leading-tight line-clamp-1 no-underline transition-colors mb-1.5 w-full" title="{{ $rel->name }}">
                                            {{ $rel->name }}
                                        </a>

                                        <!-- Pricing -->
                                        <div class="flex items-center justify-center gap-1.5 font-bold text-xs sm:text-sm flex-wrap">
                                            @if($relDisc > 0)
                                                <span class="text-stone-400 line-through text-[10px] sm:text-xs font-normal">৳ {{ number_format($relPrice) }}</span>
                                            @endif
                                            <span class="text-[#a28e46]">৳ {{ number_format($relEff) }}</span>
                                        </div>
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

</div>

<!-- 5. Mobile Sticky Bottom Action Bar (Ultra Sleek) -->
<div id="pdMobileStickyBar" class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-stone-200/90 px-3.5 py-2.5 z-40 shadow-[0_-4px_20px_rgba(0,0,0,0.08)] flex items-center justify-between gap-3 transform translate-y-full transition-transform duration-300">
    <div class="flex items-center gap-2.5 min-w-0">
        <img id="stickyBarImg" src="{{ asset($product->image) }}" class="w-9 h-9 object-cover rounded-md border border-stone-200 flex-shrink-0" alt="">
        <div class="min-w-0">
            <h5 class="text-xs font-bold text-stone-900 truncate leading-tight mb-0.5">{{ $product->name }}</h5>
            <span id="stickyBarPrice" class="font-bold text-xs text-[#a28e46]">৳ {{ number_format($effectivePrice) }}</span>
        </div>
    </div>
    <div class="flex items-center gap-2 flex-shrink-0">
        <button type="button" 
                class="bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase px-3.5 py-2 rounded-md shadow-xs flex items-center gap-1 cursor-pointer focus:outline-none active:scale-95"
                onclick="executeAddToCart(false)">
            <i class="fa-solid fa-bag-shopping text-[11px]"></i>
            <span>ADD</span>
        </button>
        <button type="button" 
                class="bg-[#222222] hover:bg-black text-white font-bold text-xs uppercase px-3.5 py-2 rounded-md shadow-xs flex items-center gap-1 cursor-pointer focus:outline-none active:scale-95"
                onclick="executeAddToCart(true)">
            <span>BUY NOW</span>
        </button>
    </div>
</div>

<!-- Variation Matrix & Interactivity Scripts -->
<script>
    const productData = {
        id: {{ $product->id }},
        name: @json($product->name),
        slug: @json($product->slug),
        basePrice: {{ (float)$product->price }},
        baseEffectivePrice: {{ (float)$effectivePrice }},
        hasVariations: {{ $product->has_variations ? 'true' : 'false' }},
        baseSku: @json($product->sku ?? ''),
        baseImage: @json(asset($product->image)),
        variations: @json($variationsJson ?? [])
    };

    let selectedAttributes = {};
    let selectedVariation = null;
    let quantity = 1;

    // Switch main gallery image
    function switchMainProductImage(url, btn) {
        const mainImg = document.getElementById('mainProductImg');
        if (mainImg) mainImg.src = url;

        if (btn) {
            document.querySelectorAll('.pd-thumb-btn').forEach(b => {
                b.classList.remove('border-[#a28e46]', 'shadow-sm', 'opacity-100');
                b.classList.add('border-stone-200', 'opacity-70');
            });
            btn.classList.add('border-[#a28e46]', 'shadow-sm', 'opacity-100');
            btn.classList.remove('border-stone-200', 'opacity-70');
        }
    }

    // Select Variation Attribute Value
    function selectProductAttribute(attrId, valId, label) {
        selectedAttributes[attrId] = valId;

        // Update UI pill styles
        const container = document.querySelector(`[data-attr-id="${attrId}"]`);
        if (container) {
            container.querySelectorAll('.pd-attr-option').forEach(btn => {
                btn.classList.remove('border-[#a28e46]', 'bg-[#faf7f0]', 'text-[#a28e46]');
                btn.classList.add('border-stone-300', 'bg-white', 'text-stone-700');
            });
            const activeBtn = container.querySelector(`[data-value-id="${valId}"]`);
            if (activeBtn) {
                activeBtn.classList.remove('border-stone-300', 'bg-white', 'text-stone-700');
                activeBtn.classList.add('border-[#a28e46]', 'bg-[#faf7f0]', 'text-[#a28e46]');
            }
        }

        const labelEl = document.getElementById(`selectedLabel_${attrId}`);
        if (labelEl) labelEl.textContent = label;

        matchVariation();
    }

    // Match selected combination to variation
    function matchVariation() {
        if (!productData.hasVariations || !productData.variations.length) return;

        selectedVariation = productData.variations.find(v => {
            return Object.keys(selectedAttributes).every(attrId => {
                return String(v.attribute_combinations[attrId]) === String(selectedAttributes[attrId]);
            });
        });

        const priceEl = document.getElementById('pdPriceDisplay');
        const origPriceEl = document.getElementById('pdOriginalPriceDisplay');
        const saveBadge = document.getElementById('pdSaveBadge');
        const skuEl = document.getElementById('pdSkuDisplay');
        const stockEl = document.getElementById('pdStockIndicator');
        const addBtn = document.getElementById('pdAddToCartBtn');
        const buyBtn = document.getElementById('pdBuyNowBtn');
        const stickyPrice = document.getElementById('stickyBarPrice');

        if (selectedVariation) {
            // Update Price
            const price = selectedVariation.price;
            const effPrice = selectedVariation.effective_price;
            priceEl.textContent = `৳ ${effPrice.toLocaleString()}`;
            if (stickyPrice) stickyPrice.textContent = `৳ ${effPrice.toLocaleString()}`;

            if (price > effPrice) {
                origPriceEl.textContent = `৳ ${price.toLocaleString()}`;
                origPriceEl.classList.remove('hidden');
                const discPct = Math.round(((price - effPrice) / price) * 100);
                saveBadge.textContent = `Save ৳${(price - effPrice).toLocaleString()} (${discPct}% OFF)`;
                saveBadge.classList.remove('hidden');
            } else {
                origPriceEl.classList.add('hidden');
                saveBadge.classList.add('hidden');
            }

            // Update SKU
            if (selectedVariation.sku && skuEl) {
                skuEl.textContent = `SKU: ${selectedVariation.sku}`;
            }

            // Update Image if variation has custom photo
            if (selectedVariation.image) {
                switchMainProductImage(selectedVariation.image, null);
                const stickyImg = document.getElementById('stickyBarImg');
                if (stickyImg) stickyImg.src = selectedVariation.image;
            }

            // Stock Check
            if (selectedVariation.in_stock) {
                stockEl.innerHTML = `<i class="fa-solid fa-circle text-[8px]"></i> <span>In Stock (${selectedVariation.stock} available)</span>`;
                stockEl.className = 'text-xs font-medium flex items-center gap-1.5 text-emerald-600';
                addBtn.disabled = false;
                buyBtn.disabled = false;
                addBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                buyBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                stockEl.innerHTML = `<i class="fa-solid fa-circle text-[8px]"></i> <span>Out of Stock</span>`;
                stockEl.className = 'text-xs font-medium flex items-center gap-1.5 text-rose-500';
                addBtn.disabled = true;
                buyBtn.disabled = true;
                addBtn.classList.add('opacity-50', 'cursor-not-allowed');
                buyBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
    }

    // Change Quantity
    function changeProductQty(delta) {
        quantity += delta;
        if (quantity < 1) quantity = 1;
        document.getElementById('pdQuantityInput').value = quantity;
    }

    // Execute Add to Cart / Buy Now
    async function executeAddToCart(isBuyNow = false) {
        if (productData.hasVariations && !selectedVariation) {
            if (typeof window.showToast === 'function') {
                window.showToast('Please select your preferred options first.', 'error');
            }
            return;
        }

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const payload = {
            qty: quantity,
            quantity: quantity,
            variation_id: selectedVariation ? selectedVariation.id : null,
            attributes: selectedAttributes
        };

        const targetBtn = isBuyNow ? document.getElementById('pdBuyNowBtn') : document.getElementById('pdAddToCartBtn');
        const origContent = targetBtn ? targetBtn.innerHTML : '';
        if (targetBtn) {
            targetBtn.innerHTML = `<i class="fa-solid fa-spinner animate-spin text-xs"></i> <span>Processing...</span>`;
            targetBtn.disabled = true;
        }

        try {
            const res = await fetch(`/cart/add-page/${productData.id}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json();

            if (res.ok && data.success) {
                if (typeof window.updateCartQtyBadge === 'function') window.updateCartQtyBadge();
                
                if (isBuyNow) {
                    window.location.href = "{{ route('checkout') }}";
                } else {
                    if (typeof window.showToast === 'function') window.showToast('Product added to bag!');
                    if (typeof window.openOffcanvasCart === 'function') window.openOffcanvasCart();
                }
            } else {
                if (typeof window.showToast === 'function') {
                    window.showToast(data.message || 'Could not add product to cart', 'error');
                }
            }
        } catch (err) {
            console.error('Add to cart error:', err);
            if (typeof window.showToast === 'function') {
                window.showToast('Failed to add to cart. Please try again.', 'error');
            }
        } finally {
            if (targetBtn) {
                targetBtn.innerHTML = origContent;
                targetBtn.disabled = false;
            }
        }
    }

    // Tabs Switcher
    document.querySelectorAll('.pd-tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            document.querySelectorAll('.pd-tab-btn').forEach(b => {
                b.classList.remove('active', 'text-[#a28e46]', 'border-[#a28e46]');
                b.classList.add('text-stone-400', 'border-transparent');
            });
            this.classList.add('active', 'text-[#a28e46]', 'border-[#a28e46]');
            this.classList.remove('text-stone-400', 'border-transparent');

            document.querySelectorAll('.pd-tab-pane').forEach(p => p.classList.add('hidden'));
            const targetPane = document.getElementById(targetId);
            if (targetPane) targetPane.classList.remove('hidden');
        });
    });

    function switchToReviewsTab() {
        const revBtn = document.querySelector('[data-target="tab-reviews"]');
        if (revBtn) revBtn.click();
    }

    // Copy Link Helper
    function copyProductLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            if (typeof window.showToast === 'function') window.showToast('Product link copied to clipboard!');
        });
    }

    // Mobile Sticky Bottom Bar Scroll Listener
    window.addEventListener('scroll', () => {
        const stickyBar = document.getElementById('pdMobileStickyBar');
        const mainBtn = document.getElementById('pdAddToCartBtn');
        if (!stickyBar || !mainBtn) return;

        const rect = mainBtn.getBoundingClientRect();
        if (rect.bottom < 0) {
            stickyBar.classList.remove('translate-y-full');
        } else {
            stickyBar.classList.add('translate-y-full');
        }
    });

    // DOMContentLoaded Initializers
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Auto-select first variation option on load
        if (productData.hasVariations) {
            document.querySelectorAll('#pdVariationsWrap [data-attr-id]').forEach(group => {
                const firstBtn = group.querySelector('.pd-attr-option');
                if (firstBtn) firstBtn.click();
            });
        }

        // 2. Interactive Fluid Image Magnifier Zoom Lens (Desktop)
        const imgContainer = document.getElementById('mainImgContainer');
        const mainImg = document.getElementById('mainProductImg');

        if (imgContainer && mainImg) {
            imgContainer.addEventListener('mouseenter', () => {
                if (window.innerWidth >= 768) {
                    mainImg.style.transform = 'scale(2.2)';
                }
            });

            imgContainer.addEventListener('mousemove', (e) => {
                if (window.innerWidth < 768) return;
                const rect = imgContainer.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                mainImg.style.transformOrigin = `${x}% ${y}%`;
            });

            imgContainer.addEventListener('mouseleave', () => {
                mainImg.style.transform = 'scale(1)';
                mainImg.style.transformOrigin = 'center center';
            });
        }

        // 3. Mount Splide for Related Products Carousel (Standard with rest of the site)
        const relatedSplideEl = document.getElementById('relatedProductsSplide');
        if (relatedSplideEl && window.Splide && !relatedSplideEl.__splideMounted) {
            try {
                const totalSlides = relatedSplideEl.querySelectorAll('.splide__slide').length;
                const relatedSplide = new Splide(relatedSplideEl, {
                    type: totalSlides > 4 ? 'loop' : 'slide',
                    perPage: 4,
                    perMove: 1,
                    gap: '16px',
                    pagination: false,
                    arrows: totalSlides > 2,
                    drag: true,
                    rewind: true,
                    breakpoints: {
                        1200: { perPage: 4, gap: '16px' },
                        992: { perPage: 3, gap: '14px' },
                        768: { perPage: 2, gap: '12px' },
                        576: { perPage: 2, gap: '10px' }
                    }
                });
                relatedSplide.mount();
                relatedSplideEl.__splideMounted = true;
            } catch (e) {
                console.error('Failed to mount related products Splide:', e);
            }
        }
    });
</script>
@endsection