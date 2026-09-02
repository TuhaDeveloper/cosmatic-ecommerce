@extends('ecommerce.master')

@section('title', 'My Wishlist - Harosa Luxury')

@section('main-section')
<div class="bg-stone-50/60 min-h-screen pb-20">

    <!-- 1. Breadcrumb & Header -->
    <div class="bg-white border-b border-stone-200/60 py-8">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 text-xs text-[#a28e46] font-bold uppercase tracking-wider mb-1">
                        <i class="fa-solid fa-heart text-[10px]"></i>
                        <span>SAVED LUXURY PIECES</span>
                    </div>
                    <h1 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 uppercase tracking-tight">
                        MY WISHLIST
                    </h1>
                    <nav class="flex items-center gap-2 text-xs text-stone-400 mt-1" aria-label="Breadcrumb">
                        <a href="/" class="hover:text-[#a28e46] transition-colors no-underline text-stone-400">Home</a>
                        <span class="text-stone-300">/</span>
                        <span class="text-stone-800 font-medium">Wishlist</span>
                    </nav>
                </div>

                <div class="flex items-center gap-3">
                    <span id="wishlistTotalBadge" class="bg-[#faf7f0] border border-[#a28e46]/30 text-[#a28e46] text-xs font-bold px-3.5 py-1.5 rounded-full font-mono">
                        {{ $wishlists->count() }} {{ $wishlists->count() == 1 ? 'Item' : 'Items' }}
                    </span>
                    @if($wishlists->count() > 0)
                        <form action="{{ route('wishlist.removeAll') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear your entire wishlist?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-stone-100 hover:bg-rose-50 hover:text-rose-600 text-stone-600 border border-stone-200 text-xs font-bold px-3.5 py-1.5 rounded-sm transition-colors cursor-pointer flex items-center gap-1.5">
                                <i class="fa-regular fa-trash-can text-[11px]"></i>
                                <span>Clear All</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Wishlist Grid Content -->
    <div class="container mx-auto px-4 max-w-7xl py-10">
        @if($wishlists->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6" id="wishlistItemsGrid">
                @foreach ($wishlists as $wishlist)
                    @php
                        $product = $wishlist->product;
                        if (!$product) continue;
                        $effectivePrice = $product->effective_price;
                        $originalPrice = (float)$product->price;
                        $hasDiscount = $effectivePrice < $originalPrice;
                        $discountPercent = $originalPrice > 0 && $hasDiscount ? round((($originalPrice - $effectivePrice) / $originalPrice) * 100) : 0;
                        $categoryName = $product->category->name ?? 'Beauty';
                        $productImage = $product->image ? asset($product->image) : asset('static/default-product.jpg');
                    @endphp
                    <div class="group relative bg-white border border-stone-200/80 rounded-sm overflow-hidden flex flex-col justify-between p-3 sm:p-4 transition-all duration-300 hover:shadow-xl hover:border-[#a28e46]/40 wishlist-card-item" id="wishlist-row-{{ $product->id }}">
                        
                        <!-- Remove from Wishlist Floating Button -->
                        <button type="button" 
                                class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/95 backdrop-blur-sm text-rose-500 shadow-md flex items-center justify-center text-xs z-30 hover:bg-rose-50 transition-all cursor-pointer focus:outline-none"
                                onclick="removeWishlistItem({{ $product->id }})"
                                title="Remove from Wishlist">
                            <i class="fa-solid fa-heart text-rose-500"></i>
                        </button>

                        <!-- Image Stage -->
                        <div class="relative w-full aspect-[4/5] overflow-hidden bg-stone-50 mb-3 group/img">
                            @if($discountPercent > 0)
                                <span class="absolute top-2 left-2 bg-black text-white text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider z-10">
                                    -{{ $discountPercent }}%
                                </span>
                            @endif

                            <a href="{{ route('product.details', $product->slug) }}" class="block w-full h-full">
                                <img src="{{ $productImage }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-500 block"
                                     loading="lazy"
                                     onerror="this.onerror=null; this.src='/static/default-product.jpg';">
                            </a>

                            <!-- Mobile 1-Tap Quick Add Button -->
                            <button type="button" 
                                    class="md:hidden absolute bottom-2 right-2 w-8 h-8 rounded-full bg-[#a28e46] active:bg-[#8e7b39] text-white shadow-md flex items-center justify-center text-xs z-20 cursor-pointer focus:outline-none transition-transform active:scale-95"
                                    onclick="event.stopPropagation(); handleQuickAddToCart({{ $product->id }}, {{ $product->has_variations ? 'true' : 'false' }}, '{{ $product->slug }}');"
                                    aria-label="Add to cart">
                                <i class="fa-solid fa-bag-shopping text-[11px]"></i>
                            </button>
                        </div>

                        <!-- Info & Action -->
                        <div class="flex flex-col flex-grow justify-between text-center">
                            <div>
                                <span class="text-[10px] text-stone-400 font-medium uppercase tracking-wider block mb-1">
                                    {{ $categoryName }}
                                </span>
                                <a href="{{ route('product.details', $product->slug) }}" class="font-serif text-xs sm:text-sm font-bold text-stone-900 hover:text-[#a28e46] uppercase tracking-wider block line-clamp-1 no-underline transition-colors mb-2">
                                    {{ $product->name }}
                                </a>
                            </div>

                            <div class="pt-2">
                                <!-- Price -->
                                <div class="flex items-center justify-center gap-2 font-bold text-xs sm:text-sm mb-3">
                                    @if($hasDiscount)
                                        <span class="text-stone-400 line-through text-xs font-normal">৳ {{ number_format($originalPrice) }}</span>
                                    @endif
                                    <span class="text-[#a28e46]">৳ {{ number_format($effectivePrice) }}</span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="space-y-1.5">
                                    <button type="button" 
                                            class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-[11px] uppercase tracking-wider py-2 px-3 rounded-none shadow-sm transition-all flex items-center justify-center gap-1.5 cursor-pointer focus:outline-none"
                                            onclick="handleQuickAddToCart({{ $product->id }}, {{ $product->has_variations ? 'true' : 'false' }}, '{{ $product->slug }}');">
                                        <i class="fa-solid fa-cart-shopping text-[10px]"></i>
                                        <span>ADD TO BAG</span>
                                    </button>
                                    <a href="{{ route('product.details', $product->slug) }}" class="w-full bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold text-[11px] uppercase tracking-wider py-1.5 px-3 rounded-none transition-colors block no-underline text-center">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty Wishlist State -->
            <div class="py-20 px-4 text-center bg-white rounded-sm border border-stone-200/80 shadow-sm max-w-lg mx-auto flex flex-col items-center justify-center">
                <div class="w-16 h-16 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-2xl mb-4 shadow-inner">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h2 class="font-serif font-bold text-xl text-stone-900 uppercase tracking-wide mb-2">
                    Your Wishlist is Empty
                </h2>
                <p class="text-xs text-stone-500 leading-relaxed mb-6 max-w-sm">
                    Explore our luxury catalog and save your favorite formulations, skincare essentials, and perfumes here for easy access.
                </p>
                <a href="{{ route('product.archive') }}" class="bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest px-8 py-3.5 rounded-none shadow-md transition-all no-underline">
                    Discover Products
                </a>
            </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
    async function removeWishlistItem(productId) {
        const card = document.getElementById(`wishlist-row-${productId}`);
        if (card) {
            card.style.opacity = '0.4';
            card.style.transform = 'scale(0.96)';
        }

        try {
            const res = await fetch(`/add-remove-wishlist/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await res.json();
            if (data.success) {
                if (card) {
                    card.remove();
                }
                const remaining = document.querySelectorAll('.wishlist-card-item').length;
                const badge = document.getElementById('wishlistTotalBadge');
                if (badge) badge.textContent = `${remaining} ${remaining === 1 ? 'Item' : 'Items'}`;
                
                // Update header wishlist count badge
                if (typeof window.updateWishlistCountBadge === 'function') {
                    window.updateWishlistCountBadge(remaining);
                }

                if (remaining === 0) {
                    window.location.reload();
                }
            }
        } catch(err) {
            console.error('Wishlist removal error:', err);
            if (card) {
                card.style.opacity = '1';
                card.style.transform = 'none';
            }
        }
    }
</script>
@endpush
@endsection