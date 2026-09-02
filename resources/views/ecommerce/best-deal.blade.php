@extends('ecommerce.master')

@section('title', 'Best Deals & Exclusive Offers - Harosa Luxury')

@section('main-section')
<div class="bg-stone-50/60 min-h-screen pb-20">

    <!-- 1. Luxury Flash Sale Hero Banner -->
    <div class="bg-gradient-to-r from-[#111111] via-[#1c1917] to-[#262013] text-white py-12 md:py-16 relative overflow-hidden border-b border-[#a28e46]/30">
        <!-- Subtle Gold Decorative Glow -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#a28e46]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-[#a28e46]/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 max-w-7xl relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8 text-center lg:text-left">
                
                <!-- Left: Title & Subtitle -->
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 bg-[#a28e46]/20 border border-[#a28e46]/40 text-[#d4af37] px-3.5 py-1 text-[11px] font-bold uppercase tracking-widest rounded-full mb-3.5">
                        <i class="fa-solid fa-bolt text-xs"></i>
                        <span>LIMITED TIME EXCLUSIVE OFFERS</span>
                    </div>
                    <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-white uppercase mb-3">
                        BEST BEAUTY & COSMETICS DEALS
                    </h1>
                    <p class="text-stone-300 text-xs sm:text-sm font-light leading-relaxed max-w-xl">
                        Indulge in our curated selection of premium skincare, makeup, and perfumes at exclusive celebratory prices. Handpicked luxury for your daily routine.
                    </p>
                </div>

                <!-- Right: Live Flash Deal Countdown Timer -->
                <div class="bg-black/40 backdrop-blur-md border border-[#a28e46]/40 rounded-sm p-5 sm:p-6 shadow-2xl flex flex-col items-center mx-auto lg:mx-0">
                    <span class="text-[10px] uppercase font-bold tracking-widest text-stone-400 mb-3 flex items-center gap-1.5">
                        <i class="fa-regular fa-clock text-[#a28e46]"></i> DEALS EXPIRE IN
                    </span>
                    <div class="flex items-center gap-2 sm:gap-3" id="dealCountdown">
                        <div class="flex flex-col items-center">
                            <span class="w-12 sm:w-14 h-12 sm:h-14 bg-stone-900 border border-stone-700/80 rounded flex items-center justify-center font-mono font-bold text-lg sm:text-xl text-[#d4af37] shadow-inner" id="cdDays">02</span>
                            <span class="text-[9px] uppercase tracking-wider text-stone-400 mt-1">Days</span>
                        </div>
                        <span class="text-stone-500 font-bold text-lg pb-4">:</span>
                        <div class="flex flex-col items-center">
                            <span class="w-12 sm:w-14 h-12 sm:h-14 bg-stone-900 border border-stone-700/80 rounded flex items-center justify-center font-mono font-bold text-lg sm:text-xl text-white shadow-inner" id="cdHours">14</span>
                            <span class="text-[9px] uppercase tracking-wider text-stone-400 mt-1">Hours</span>
                        </div>
                        <span class="text-stone-500 font-bold text-lg pb-4">:</span>
                        <div class="flex flex-col items-center">
                            <span class="w-12 sm:w-14 h-12 sm:h-14 bg-stone-900 border border-stone-700/80 rounded flex items-center justify-center font-mono font-bold text-lg sm:text-xl text-white shadow-inner" id="cdMinutes">36</span>
                            <span class="text-[9px] uppercase tracking-wider text-stone-400 mt-1">Mins</span>
                        </div>
                        <span class="text-stone-500 font-bold text-lg pb-4">:</span>
                        <div class="flex flex-col items-center">
                            <span class="w-12 sm:w-14 h-12 sm:h-14 bg-stone-900 border border-stone-700/80 rounded flex items-center justify-center font-mono font-bold text-lg sm:text-xl text-[#d4af37] shadow-inner" id="cdSeconds">50</span>
                            <span class="text-[9px] uppercase tracking-wider text-stone-400 mt-1">Secs</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 2. Breadcrumb & Info Bar -->
    <div class="bg-white border-b border-stone-200/60 py-3.5 mb-8">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-stone-500">
                <nav class="flex items-center gap-2" aria-label="Breadcrumb">
                    <a href="/" class="hover:text-[#a28e46] transition-colors no-underline">Home</a>
                    <span class="text-stone-300">/</span>
                    <span class="text-stone-900 font-medium">Best Deals</span>
                </nav>
                <div class="flex items-center gap-1 font-medium">
                    <i class="fa-solid fa-tags text-[#a28e46]"></i>
                    <span>Showing <strong id="bestDealCount" class="text-stone-900">{{ $products->total() }}</strong> curated special offers</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Deals Container with AJAX Grid -->
    <div class="container mx-auto px-4 max-w-7xl">
        <div id="bestDealsProductsContainer" class="min-h-[450px] relative">
            <!-- Loading Spinner Overlay -->
            <div id="dealLoadingOverlay" class="absolute inset-0 bg-white/75 backdrop-blur-[1px] z-20 hidden flex items-center justify-center">
                <div class="w-10 h-10 border-3 border-stone-200 border-t-[#a28e46] rounded-full animate-spin"></div>
            </div>

            @include('ecommerce.partials.best-deal-grid')
        </div>
    </div>

</div>

@push('scripts')
<script>
    // Live Flash Deal Countdown Logic
    (function initCountdown() {
        const targetDate = new Date();
        targetDate.setDate(targetDate.getDate() + 3);
        targetDate.setHours(23, 59, 59, 999);

        function updateTimer() {
            const now = new Date().getTime();
            const diff = targetDate.getTime() - now;

            if (diff <= 0) return;

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            const dEl = document.getElementById('cdDays');
            const hEl = document.getElementById('cdHours');
            const mEl = document.getElementById('cdMinutes');
            const sEl = document.getElementById('cdSeconds');

            if (dEl) dEl.textContent = String(days).padStart(2, '0');
            if (hEl) hEl.textContent = String(hours).padStart(2, '0');
            if (mEl) mEl.textContent = String(minutes).padStart(2, '0');
            if (sEl) sEl.textContent = String(seconds).padStart(2, '0');
        }

        updateTimer();
        setInterval(updateTimer, 1000);
    })();

    // Handle Best Deals AJAX Pagination
    window.handleDealPagination = async function(e, targetUrl) {
        if (e) e.preventDefault();
        if (!targetUrl) return;

        const loading = document.getElementById('dealLoadingOverlay');
        if (loading) loading.classList.remove('hidden');

        try {
            const res = await fetch(targetUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();
            if (data && data.html) {
                const container = document.getElementById('bestDealsProductsContainer');
                if (container) {
                    container.innerHTML = `<div id="dealLoadingOverlay" class="absolute inset-0 bg-white/75 backdrop-blur-[1px] z-20 hidden flex items-center justify-center"><div class="w-10 h-10 border-3 border-stone-200 border-t-[#a28e46] rounded-full animate-spin"></div></div>` + data.html;
                }
                window.history.pushState({}, '', targetUrl);

                const countEl = document.getElementById('bestDealCount');
                if (countEl && data.total !== undefined) countEl.textContent = data.total;

                const mainArea = document.getElementById('bestDealsProductsContainer');
                if (mainArea) {
                    mainArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            } else {
                window.location.href = targetUrl;
            }
        } catch(err) {
            console.error('Deal pagination error:', err);
            window.location.href = targetUrl;
        } finally {
            if (loading) loading.classList.add('hidden');
        }
    };
</script>
@endpush
@endsection
