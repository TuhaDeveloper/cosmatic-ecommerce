@extends('ecommerce.master')

@section('title', 'Collections & Categories - Harosa Luxury Cosmetics')

@section('main-section')
<div class="bg-stone-50/50 min-h-screen pb-20">

    <!-- 1. Editorial Header Banner -->
    <div class="bg-white border-b border-stone-200/60 py-10 sm:py-14 relative overflow-hidden">
        <div class="container mx-auto px-4 max-w-7xl text-center">
            <div class="inline-flex items-center gap-2 bg-[#faf7f0] border border-[#a28e46]/30 text-[#a28e46] px-3.5 py-1 text-[11px] font-bold uppercase tracking-widest rounded-full mb-3 shadow-xs">
                <i class="fa-solid fa-sparkles text-[10px]"></i>
                <span>CURATED BEAUTY EDIT</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-stone-900 tracking-tight uppercase mb-3">
                EXPLORE OUR COLLECTIONS
            </h1>
            <p class="text-stone-500 text-xs sm:text-sm font-normal max-w-xl mx-auto leading-relaxed mb-4">
                Discover our specialized ranges crafted for luxury skincare, high-performance cosmetics, signature fragrances, and everyday beauty rituals.
            </p>
            <nav class="flex items-center justify-center gap-2 text-xs text-stone-400" aria-label="Breadcrumb">
                <a href="/" class="hover:text-[#a28e46] transition-colors no-underline">Home</a>
                <span class="text-stone-300">/</span>
                <span class="text-stone-800 font-medium">Collections</span>
            </nav>
        </div>
    </div>

    <!-- 2. Collections Visual Grid -->
    <div class="container mx-auto px-4 max-w-7xl py-10 sm:py-12">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($categories as $category)
                @php
                    $catImage = $category->image ? asset($category->image) : asset('static/default-product.jpg');
                    $productCount = $category->products_count ?? $category->products()->count();
                    $hasChildren = $category->children && count($category->children) > 0;
                @endphp
                <div class="group relative bg-white border border-stone-200/80 rounded-sm overflow-hidden flex flex-col justify-between shadow-sm hover:shadow-xl transition-all duration-300 hover:border-[#a28e46]/50">
                    
                    <!-- Top Visual Image Stage -->
                    <a href="{{ route('product.archive') }}?categories[]={{ $category->slug }}" class="block relative w-full aspect-[4/4] overflow-hidden bg-stone-100 group/img">
                        <img src="{{ $catImage }}" 
                             alt="{{ $category->name }}" 
                             class="w-full h-full object-cover group-hover/img:scale-108 transition-transform duration-700 block"
                             loading="lazy"
                             onerror="this.onerror=null; this.src='/static/default-product.jpg';">
                        
                        <!-- Overlay Gradient on Hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-40 group-hover/img:opacity-70 transition-opacity duration-300"></div>

                        <!-- Product Count Badge -->
                        <span class="absolute top-2.5 right-2.5 bg-white/95 backdrop-blur-sm text-stone-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-sm font-mono">
                            {{ $productCount }} {{ $productCount === 1 ? 'Item' : 'Items' }}
                        </span>

                        <!-- Hover Bottom CTA -->
                        <div class="absolute inset-x-0 bottom-0 p-3 text-white flex items-center justify-between translate-y-2 opacity-0 group-hover/img:translate-y-0 group-hover/img:opacity-100 transition-all duration-300">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-[#d4af37]">Explore</span>
                            <i class="fa-solid fa-arrow-right text-xs text-[#d4af37]"></i>
                        </div>
                    </a>

                    <!-- Category Content -->
                    <div class="p-4 flex flex-col flex-grow justify-between text-center bg-white">
                        <div>
                            <h3 class="font-serif text-sm sm:text-base font-bold text-stone-900 group-hover:text-[#a28e46] transition-colors uppercase tracking-wider mb-1 line-clamp-1">
                                <a href="{{ route('product.archive') }}?categories[]={{ $category->slug }}" class="no-underline text-inherit">
                                    {{ $category->name }}
                                </a>
                            </h3>
                            @if($category->description)
                                <p class="text-[11px] text-stone-500 line-clamp-2 mb-3">
                                    {{ $category->description }}
                                </p>
                            @endif
                        </div>

                        <!-- Sub-categories Quick Links -->
                        @if($hasChildren)
                            <div class="pt-3 border-t border-stone-100 flex flex-wrap gap-1.5 justify-center">
                                @foreach($category->children->take(3) as $child)
                                    <a href="{{ route('product.archive') }}?categories[]={{ $child->slug }}" 
                                       class="text-[10px] bg-stone-50 hover:bg-[#a28e46] hover:text-white text-stone-600 font-medium px-2 py-0.5 rounded-sm transition-colors no-underline">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="pt-2">
                                <a href="{{ route('product.archive') }}?categories[]={{ $category->slug }}" class="inline-flex items-center gap-1.5 text-[11px] font-bold text-[#a28e46] hover:text-[#8e7b39] uppercase tracking-wider transition-colors no-underline">
                                    <span>Shop Collection</span>
                                    <i class="fa-solid fa-angle-right text-[10px]"></i>
                                </a>
                            </div>
                        @endif
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded border border-stone-200 shadow-sm">
                    <i class="fa-solid fa-magnifying-glass text-3xl text-stone-300 mb-3"></i>
                    <h3 class="font-serif font-bold text-stone-800 uppercase">No Collections Found</h3>
                    <p class="text-xs text-stone-500 mt-1">Please check back later as we update our product catalog.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- 3. Value Pillars Luxury Banner -->
    <div class="container mx-auto px-4 max-w-7xl mt-4">
        <div class="bg-white border border-stone-200/80 rounded-sm p-6 sm:p-8 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center sm:text-left">
                
                <div class="flex items-center gap-3.5 justify-center sm:justify-start">
                    <div class="w-12 h-12 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-lg flex-shrink-0 shadow-xs">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div>
                        <h4 class="font-serif font-bold text-xs uppercase tracking-wider text-stone-900 mb-0.5">100% Authentic</h4>
                        <p class="text-[11px] text-stone-500">Directly sourced & certified genuine.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 justify-center sm:justify-start">
                    <div class="w-12 h-12 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-lg flex-shrink-0 shadow-xs">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <div>
                        <h4 class="font-serif font-bold text-xs uppercase tracking-wider text-stone-900 mb-0.5">Express Delivery</h4>
                        <p class="text-[11px] text-stone-500">Fast nationwide courier delivery.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 justify-center sm:justify-start">
                    <div class="w-12 h-12 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-lg flex-shrink-0 shadow-xs">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h4 class="font-serif font-bold text-xs uppercase tracking-wider text-stone-900 mb-0.5">Secure Checkout</h4>
                        <p class="text-[11px] text-stone-500">Encrypted instant payment & COD.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 justify-center sm:justify-start">
                    <div class="w-12 h-12 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-lg flex-shrink-0 shadow-xs">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <h4 class="font-serif font-bold text-xs uppercase tracking-wider text-stone-900 mb-0.5">Beauty Concierge</h4>
                        <p class="text-[11px] text-stone-500">Expert skincare & product guidance.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
