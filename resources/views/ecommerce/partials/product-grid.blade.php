@if($products->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-5"
        id="productsGridList">
        @foreach($products as $product)
            @php
                $effectivePrice = $product->effective_price;
                $originalPrice = (float) $product->price;
                $hasDiscount = $effectivePrice < $originalPrice;
                $discountPercent = $originalPrice > 0 && $hasDiscount ? round((($originalPrice - $effectivePrice) / $originalPrice) * 100) : 0;
                $categoryName = $product->category->name ?? 'Beauty';
                $productImage = $product->image ? asset($product->image) : asset('static/default-product.jpg');
            @endphp
            <div
                class="group relative bg-white border border-stone-200/80 rounded-xl sm:rounded-sm overflow-hidden flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-[#a28e46]/40">

                <!-- Full-Bleed Product Image Stage (Edge-to-Edge) -->
                <div class="relative w-full aspect-[4/5] overflow-hidden bg-stone-100/50 group/img">
                    <!-- Black NEW Tag -->
                    <span
                        class="absolute top-2 left-2 bg-[#222222] text-white text-[10px] font-bold px-2 py-0.5 rounded-none uppercase tracking-wider z-10 shadow-xs">NEW</span>

                    <!-- Discount Tag -->
                    @if($discountPercent > 0)
                        <span
                            class="absolute top-2 right-2 bg-[#222222] text-white text-[10px] font-bold px-2 py-0.5 rounded-none uppercase tracking-wider z-10 shadow-xs">-{{ $discountPercent }}%</span>
                    @endif

                    <!-- Product Image -->
                    <a href="{{ route('product.details', $product->slug) }}" class="block w-full h-full">
                        <img src="{{ $productImage }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 block"
                            alt="{{ $product->name }}" loading="lazy"
                            onerror="this.onerror=null; this.src='/static/default-product.jpg';">
                    </a>

                    <!-- Mobile 1-Tap Quick Add Button -->
                    <button type="button"
                        class="md:hidden absolute bottom-2 right-2 w-8 h-8 rounded-full bg-[#a28e46] active:bg-[#8e7b39] text-white shadow-md flex items-center justify-center text-xs z-20 cursor-pointer focus:outline-none transition-transform active:scale-95"
                        onclick="event.stopPropagation(); handleQuickAddToCart({{ $product->id }}, {{ $product->has_variations ? 'true' : 'false' }}, '{{ $product->slug }}');"
                        aria-label="Add to cart">
                        <i class="fa-solid fa-bag-shopping text-[11px]"></i>
                    </button>

                    <!-- Desktop Hover Quick Add Bar -->
                    <div
                        class="hidden md:flex absolute inset-x-0 bottom-0 p-2.5 bg-gradient-to-t from-black/70 via-black/30 to-transparent translate-y-full group-hover/img:translate-y-0 transition-transform duration-300 items-center justify-center z-20">
                        <button type="button"
                            class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-[11px] uppercase tracking-wider py-2 px-3 rounded-none shadow transition-all flex items-center justify-center gap-1.5 cursor-pointer focus:outline-none"
                            onclick="event.stopPropagation(); handleQuickAddToCart({{ $product->id }}, {{ $product->has_variations ? 'true' : 'false' }}, '{{ $product->slug }}');">
                            <i class="fa-solid fa-cart-shopping text-[10px]"></i>
                            <span>ADD TO CART</span>
                        </button>
                    </div>
                </div>

                <!-- Product Details with proper internal padding -->
                <div class="w-full flex flex-col items-center text-center p-3 mt-auto">
                    <!-- Category Tag -->
                    <div class="text-[11px] text-stone-400 flex items-center justify-center gap-1 mb-1 font-medium">
                        <i class="fa-solid fa-tag text-[9px] text-stone-400"></i>
                        <span class="truncate max-w-[140px]">{{ $categoryName }}</span>
                    </div>

                    <!-- Title -->
                    <a href="{{ route('product.details', $product->slug) }}"
                        class="font-serif text-xs md:text-sm font-bold text-stone-900 hover:text-[#a28e46] uppercase tracking-wider text-center block leading-tight line-clamp-1 no-underline transition-colors mb-1.5 w-full"
                        title="{{ $product->name }}">
                        {{ $product->name }}
                    </a>

                    <!-- Pricing -->
                    <div class="flex items-center justify-center gap-2 font-bold text-xs md:text-sm">
                        @if($hasDiscount)
                            <span class="text-stone-400 line-through text-xs font-normal">৳
                                {{ number_format($originalPrice) }}</span>
                        @endif
                        <span class="text-[#a28e46]">৳ {{ number_format($effectivePrice) }}</span>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    <!-- AJAX Luxury Pagination Controls -->
    @if(!isset($hidePagination))
        <div class="pt-10 pb-4 flex justify-center items-center" id="pdPaginationWrapper">
            <nav class="inline-flex items-center gap-1.5 bg-white p-1.5 rounded-sm border border-stone-200 shadow-sm"
                aria-label="Pagination Navigation">

                {{-- Previous Page Button --}}
                @if ($products->onFirstPage())
                    <span
                        class="px-3 py-1.5 flex items-center gap-1.5 text-stone-300 text-xs font-semibold rounded pointer-events-none select-none">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span class="hidden sm:inline">Prev</span>
                    </span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" onclick="handleShopPagination(event, this.href)"
                        class="px-3 py-1.5 flex items-center gap-1.5 text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 text-xs font-bold rounded transition-colors no-underline cursor-pointer">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span class="hidden sm:inline">Prev</span>
                    </a>
                @endif

                {{-- Page Numbers --}}
                <div class="flex items-center gap-1 px-1 border-x border-stone-100">
                    @foreach ($products->getUrlRange(1, max(1, $products->lastPage())) as $page => $url)
                        @if ($page == $products->currentPage())
                            <span
                                class="w-8 h-8 flex items-center justify-center bg-[#a28e46] text-white font-bold text-xs rounded shadow-sm">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" onclick="handleShopPagination(event, this.href)"
                                class="w-8 h-8 flex items-center justify-center text-stone-600 hover:bg-stone-100 font-semibold text-xs rounded transition-colors no-underline cursor-pointer">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                </div>

                {{-- Next Page Button --}}
                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" onclick="handleShopPagination(event, this.href)"
                        class="px-3 py-1.5 flex items-center gap-1.5 text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 text-xs font-bold rounded transition-colors no-underline cursor-pointer">
                        <span class="hidden sm:inline">Next</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                @else
                    <span
                        class="px-3 py-1.5 flex items-center gap-1.5 text-stone-300 text-xs font-semibold rounded pointer-events-none select-none">
                        <span class="hidden sm:inline">Next</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                @endif

            </nav>
        </div>
    @endif
@else
    <!-- No Products Found State -->
    <div
        class="py-16 px-4 text-center bg-white rounded border border-stone-200/80 shadow-sm flex flex-col items-center justify-center">
        <div class="w-16 h-16 rounded-full bg-stone-100 text-[#a28e46] flex items-center justify-center text-2xl mb-4">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <h3 class="font-serif font-bold text-lg text-stone-800 uppercase tracking-wide mb-1">No Products Found</h3>
        <p class="text-xs text-stone-500 max-w-sm mb-5">We couldn't find any items matching your selected criteria. Try
            adjusting your filters or search keywords.</p>
        <button type="button" onclick="clearAllShopFilters()"
            class="bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest px-6 py-2.5 rounded shadow-sm transition-colors cursor-pointer">
            Reset Filters
        </button>
    </div>
@endif