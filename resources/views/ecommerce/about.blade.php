@extends('ecommerce.master')

@section('title', 'About Us - Harosa Luxury Cosmetics')

@section('main-section')
<div class="bg-stone-50/50 min-h-screen pb-20">

    <!-- 1. Editorial Hero Header -->
    <div class="bg-gradient-to-r from-[#111111] via-[#1c1917] to-[#262013] text-white py-14 sm:py-20 relative overflow-hidden border-b border-[#a28e46]/30">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#a28e46]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="container mx-auto px-4 max-w-7xl relative z-10 text-center">
            <div class="inline-flex items-center gap-2 bg-[#a28e46]/20 border border-[#a28e46]/40 text-[#d4af37] px-4 py-1 text-[11px] font-bold uppercase tracking-widest rounded-full mb-4 shadow-xs">
                <i class="fa-solid fa-sparkles text-[10px]"></i>
                <span>OUR ESSENCE & PHILOSOPHY</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white uppercase mb-4">
                TIMELESS BEAUTY, CRAFTED IN LUXURY
            </h1>
            <p class="text-stone-300 text-xs sm:text-base font-light max-w-2xl mx-auto leading-relaxed">
                Dedicated to curating world-class skincare, cosmetics, and fragrance solutions designed to nurture your radiance and elevate every moment.
            </p>
            <nav class="flex items-center justify-center gap-2 text-xs text-stone-400 mt-6" aria-label="Breadcrumb">
                <a href="/" class="hover:text-[#a28e46] transition-colors no-underline text-stone-400">Home</a>
                <span class="text-stone-600">/</span>
                <span class="text-white font-medium">About Us</span>
            </nav>
        </div>
    </div>

    <!-- 2. Brand Story & Statistics Grid -->
    <div class="container mx-auto px-4 max-w-7xl py-12 sm:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            
            <!-- Left: Brand Narrative -->
            <div class="lg:col-span-7 space-y-5">
                <div class="inline-block border-b-2 border-[#a28e46] pb-1 mb-1">
                    <span class="text-xs font-bold text-[#a28e46] uppercase tracking-widest">Our Heritage</span>
                </div>
                <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-stone-900 leading-tight">
                    Redefining Modern Beauty with Absolute Authenticity & Elegance
                </h2>
                <p class="text-stone-600 text-xs sm:text-sm leading-relaxed font-normal">
                    Founded with a passion for transformative skincare and timeless aesthetics, <strong>Harosa</strong> was established to bridge the gap between world-class cosmetics and everyday accessibility. We believe that self-care is an art form, and every product in our collection is chosen with meticulous attention to efficacy, safety, and sensory pleasure.
                </p>
                <p class="text-stone-600 text-xs sm:text-sm leading-relaxed font-normal">
                    From dermatologically tested formulas and clean botanical actives to vibrant color palettes and signature scents, we curate only genuine, certified products that empower your unique expression.
                </p>
                <div class="pt-2 flex flex-wrap gap-4">
                    <div class="flex items-center gap-2 text-xs font-bold text-stone-800">
                        <i class="fa-solid fa-check text-[#a28e46]"></i>
                        <span>100% Guaranteed Genuine</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-bold text-stone-800">
                        <i class="fa-solid fa-check text-[#a28e46]"></i>
                        <span>Ethically Sourced & Cruelty-Free</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-bold text-stone-800">
                        <i class="fa-solid fa-check text-[#a28e46]"></i>
                        <span>Dermatologist Approved</span>
                    </div>
                </div>
            </div>

            <!-- Right: Luxury Statistics Cards -->
            <div class="lg:col-span-5">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white border border-stone-200 rounded-sm p-6 text-center shadow-sm hover:border-[#a28e46] transition-colors">
                        <span class="font-serif text-3xl sm:text-4xl font-bold text-[#a28e46] block mb-1">50K+</span>
                        <span class="text-xs font-bold text-stone-900 uppercase tracking-wider block mb-0.5">Delighted Clients</span>
                        <span class="text-[11px] text-stone-400">Nationwide trust & love</span>
                    </div>
                    <div class="bg-white border border-stone-200 rounded-sm p-6 text-center shadow-sm hover:border-[#a28e46] transition-colors">
                        <span class="font-serif text-3xl sm:text-4xl font-bold text-[#a28e46] block mb-1">100%</span>
                        <span class="text-xs font-bold text-stone-900 uppercase tracking-wider block mb-0.5">Authentic</span>
                        <span class="text-[11px] text-stone-400">Directly sourced imports</span>
                    </div>
                    <div class="bg-white border border-stone-200 rounded-sm p-6 text-center shadow-sm hover:border-[#a28e46] transition-colors">
                        <span class="font-serif text-3xl sm:text-4xl font-bold text-[#a28e46] block mb-1">99.8%</span>
                        <span class="text-xs font-bold text-stone-900 uppercase tracking-wider block mb-0.5">Satisfaction</span>
                        <span class="text-[11px] text-stone-400">5-star customer reviews</span>
                    </div>
                    <div class="bg-white border border-stone-200 rounded-sm p-6 text-center shadow-sm hover:border-[#a28e46] transition-colors">
                        <span class="font-serif text-3xl sm:text-4xl font-bold text-[#a28e46] block mb-1">2-4 Days</span>
                        <span class="text-xs font-bold text-stone-900 uppercase tracking-wider block mb-0.5">Fast Courier</span>
                        <span class="text-[11px] text-stone-400">Nationwide doorstep delivery</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- 3. Four Core Pillars -->
    <div class="bg-white border-y border-stone-200/80 py-14 sm:py-18">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold text-[#a28e46] uppercase tracking-widest block mb-1.5">Why Harosa</span>
                <h2 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 uppercase tracking-wide">
                    Our Core Pillars of Excellence
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="p-6 bg-stone-50/70 border border-stone-200/80 rounded-sm text-center hover:bg-white hover:shadow-lg hover:border-[#a28e46]/40 transition-all duration-300">
                    <div class="w-14 h-14 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-xl mx-auto mb-4 shadow-xs">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <h3 class="font-serif font-bold text-sm uppercase tracking-wider text-stone-900 mb-2">Clean Formulations</h3>
                    <p class="text-xs text-stone-500 leading-relaxed">
                        Pure ingredients free from harmful toxins, parabens, and harsh chemicals for gentle, long-lasting vitality.
                    </p>
                </div>

                <div class="p-6 bg-stone-50/70 border border-stone-200/80 rounded-sm text-center hover:bg-white hover:shadow-lg hover:border-[#a28e46]/40 transition-all duration-300">
                    <div class="w-14 h-14 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-xl mx-auto mb-4 shadow-xs">
                        <i class="fa-solid fa-flask-vial"></i>
                    </div>
                    <h3 class="font-serif font-bold text-sm uppercase tracking-wider text-stone-900 mb-2">Proven Results</h3>
                    <p class="text-xs text-stone-500 leading-relaxed">
                        Clinically tested and dermatologist-endorsed active ingredients that deliver visible, glowing improvements.
                    </p>
                </div>

                <div class="p-6 bg-stone-50/70 border border-stone-200/80 rounded-sm text-center hover:bg-white hover:shadow-lg hover:border-[#a28e46]/40 transition-all duration-300">
                    <div class="w-14 h-14 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-xl mx-auto mb-4 shadow-xs">
                        <i class="fa-solid fa-paw"></i>
                    </div>
                    <h3 class="font-serif font-bold text-sm uppercase tracking-wider text-stone-900 mb-2">Cruelty-Free</h3>
                    <p class="text-xs text-stone-500 leading-relaxed">
                        We firmly stand against animal testing. Every item is ethically created with respect for our planet and its creatures.
                    </p>
                </div>

                <div class="p-6 bg-stone-50/70 border border-stone-200/80 rounded-sm text-center hover:bg-white hover:shadow-lg hover:border-[#a28e46]/40 transition-all duration-300">
                    <div class="w-14 h-14 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-xl mx-auto mb-4 shadow-xs">
                        <i class="fa-solid fa-gem"></i>
                    </div>
                    <h3 class="font-serif font-bold text-sm uppercase tracking-wider text-stone-900 mb-2">Luxury Experience</h3>
                    <p class="text-xs text-stone-500 leading-relaxed">
                        From velvet packaging to personalized beauty support, every detail is engineered for pure luxury.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- 4. Editorial Quote Block -->
    <div class="container mx-auto px-4 max-w-4xl py-14 sm:py-18 text-center">
        <div class="bg-[#faf7f0] border border-[#a28e46]/30 rounded-sm p-8 sm:p-12 shadow-sm relative">
            <i class="fa-solid fa-quote-left text-3xl text-[#a28e46]/30 mb-4 block"></i>
            <blockquote class="font-serif text-lg sm:text-xl md:text-2xl text-stone-800 italic leading-relaxed mb-6">
                "Beauty begins the moment you decide to be yourself. Our mission is simply to provide you with the most exquisite, authentic tools to celebrate that truth."
            </blockquote>
            <div class="flex flex-col items-center">
                <span class="font-serif font-bold text-sm text-stone-900 uppercase tracking-widest">Harosa Beauty Collective</span>
                <span class="text-xs text-[#a28e46] font-medium mt-0.5">Founders & Curators</span>
            </div>
        </div>
    </div>

    <!-- 5. Shop CTA -->
    <div class="container mx-auto px-4 max-w-7xl text-center pb-8">
        <div class="bg-gradient-to-r from-stone-900 to-stone-800 text-white p-8 sm:p-12 rounded-sm shadow-xl flex flex-col items-center">
            <h3 class="font-serif text-2xl sm:text-3xl font-bold uppercase tracking-wide mb-3">
                Experience the Difference Today
            </h3>
            <p class="text-stone-300 text-xs sm:text-sm max-w-lg mb-6 leading-relaxed">
                Explore our full catalog of authentic skincare, makeup, and perfumes. Fast delivery, secure payment, and easy returns.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('product.archive') }}" class="bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest px-8 py-3.5 rounded-none shadow-md transition-all no-underline">
                    Explore Shop
                </a>
                <a href="{{ route('contact') }}" class="bg-transparent hover:bg-white/10 text-white border border-stone-500 font-bold text-xs uppercase tracking-widest px-8 py-3.5 rounded-none transition-all no-underline">
                    Contact Us
                </a>
            </div>
        </div>
    </div>

</div>
@endsection