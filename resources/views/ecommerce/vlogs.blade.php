@extends('ecommerce.master')

@section('title', 'Luxury Collections & Visual Stories - Harosa')

@section('main-section')
<div class="bg-stone-50/50 min-h-screen pb-20">

    <!-- 1. Editorial Hero Header -->
    <div class="bg-gradient-to-r from-[#111111] via-[#1c1917] to-[#262013] text-white py-14 sm:py-20 relative overflow-hidden border-b border-[#a28e46]/30">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#a28e46]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="container mx-auto px-4 max-w-7xl relative z-10 text-center">
            <div class="inline-flex items-center gap-2 bg-[#a28e46]/20 border border-[#a28e46]/40 text-[#d4af37] px-4 py-1 text-[11px] font-bold uppercase tracking-widest rounded-full mb-4 shadow-xs">
                <i class="fa-solid fa-film text-[10px]"></i>
                <span>CURATED VISUAL STORIES & REELS</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white uppercase mb-4">
                COLLECTIONS & BEAUTY STORIES
            </h1>
            <p class="text-stone-300 text-xs sm:text-base font-light max-w-xl mx-auto leading-relaxed">
                Discover step-by-step beauty tutorials, formulation spotlights, unboxing reels, and curated seasonal style guides.
            </p>
            <nav class="flex items-center justify-center gap-2 text-xs text-stone-400 mt-6" aria-label="Breadcrumb">
                <a href="/" class="hover:text-[#a28e46] transition-colors no-underline text-stone-400">Home</a>
                <span class="text-stone-600">/</span>
                <span class="text-white font-medium">Collections</span>
            </nav>
        </div>
    </div>

    <!-- 2. Video Stories Grid -->
    <div class="container mx-auto px-4 max-w-7xl py-12 sm:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($vlogs as $vlog)
                <div class="group bg-white border border-stone-200/80 rounded-sm overflow-hidden shadow-sm hover:shadow-xl hover:border-[#a28e46]/50 transition-all duration-300 flex flex-col">
                    
                    <!-- Video Embed Stage -->
                    <div class="relative w-full aspect-video bg-black overflow-hidden [&_iframe]:w-full [&_iframe]:h-full [&_iframe]:border-0">
                        {!! $vlog->frame_code !!}
                    </div>

                    <!-- Video Details -->
                    <div class="p-5 flex flex-col flex-grow justify-between bg-white">
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-[#a28e46] bg-[#faf7f0] border border-[#a28e46]/20 px-2.5 py-0.5 rounded-full">
                                <i class="fa-solid fa-play text-[8px]"></i> Visual Reel
                            </span>
                            @if($vlog->created_at)
                                <span class="text-[10px] text-stone-400 font-mono">
                                    {{ $vlog->created_at->format('M d, Y') }}
                                </span>
                            @endif
                        </div>
                        <h3 class="font-serif text-sm font-bold text-stone-900 group-hover:text-[#a28e46] uppercase tracking-wider transition-colors line-clamp-2">
                            Curated Beauty Guide & Formulations
                        </h3>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-sm border border-stone-200 shadow-sm max-w-md mx-auto">
                    <div class="w-16 h-16 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-video"></i>
                    </div>
                    <h3 class="font-serif font-bold text-lg text-stone-800 uppercase tracking-wide mb-1">Stories Updating Soon</h3>
                    <p class="text-xs text-stone-500 mb-5">We are preparing new beauty tutorials and visual stories for you. Please check back shortly.</p>
                    <a href="{{ route('product.archive') }}" class="inline-block bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest px-6 py-2.5 rounded-none shadow-sm transition-colors no-underline">
                        Explore Shop
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Luxury Pagination -->
        @if($vlogs->hasPages())
            <div class="pt-12 pb-4 flex justify-center items-center">
                <nav class="inline-flex items-center gap-1.5 bg-white p-1.5 rounded-sm border border-stone-200 shadow-sm" aria-label="Pagination">
                    @if ($vlogs->onFirstPage())
                        <span class="px-3.5 py-1.5 text-stone-300 text-xs font-semibold rounded pointer-events-none select-none">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i> Prev
                        </span>
                    @else
                        <a href="{{ $vlogs->previousPageUrl() }}" class="px-3.5 py-1.5 text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 text-xs font-bold rounded transition-colors no-underline">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i> Prev
                        </a>
                    @endif

                    <div class="flex items-center gap-1 px-1 border-x border-stone-100">
                        @foreach ($vlogs->getUrlRange(1, max(1, $vlogs->lastPage())) as $page => $url)
                            @if ($page == $vlogs->currentPage())
                                <span class="w-8 h-8 flex items-center justify-center bg-[#a28e46] text-white font-bold text-xs rounded shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center text-stone-600 hover:bg-stone-100 font-semibold text-xs rounded transition-colors no-underline">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    @if ($vlogs->hasMorePages())
                        <a href="{{ $vlogs->nextPageUrl() }}" class="px-3.5 py-1.5 text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 text-xs font-bold rounded transition-colors no-underline">
                            Next <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    @else
                        <span class="px-3.5 py-1.5 text-stone-300 text-xs font-semibold rounded pointer-events-none select-none">
                            Next <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    </div>

</div>
@endsection
