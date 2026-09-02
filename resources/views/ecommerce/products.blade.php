@extends('ecommerce.master')

@section('main-section')
@php
    /** @var \App\Models\Category|null $category */
    $totalCount = $products->total();
    $maxPrice = (float) ($maxProductPrice ?? 10000);
    $curMin = (float) ($priceMin ?? 0);
    $curMax = (float) ($priceMax && $priceMax != $maxPrice ? $priceMax : $maxPrice);
@endphp

    <div class="bg-stone-50/60 min-h-screen pb-16">

        <!-- 1. Breadcrumbs & Header Banner -->
        <div class="bg-white border-b border-stone-200/60 py-4">
            <div class="container mx-auto px-4 max-w-7xl">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                    <div>
                        <h1 class="font-serif text-xl sm:text-2xl font-bold text-gray-900 uppercase tracking-wide mb-1">
                            {{ !empty($category) ? $category->name : ($pageTitle ?? 'OUR PRODUCTS') }}
                        </h1>
                        <nav class="flex items-center gap-2 text-xs text-stone-500" aria-label="Breadcrumb">
                            <a href="/" class="hover:text-[#a28e46] transition-colors no-underline">Home</a>
                            <span class="text-stone-300">/</span>
                            <a href="{{ route('product.archive') }}"
                                class="hover:text-[#a28e46] transition-colors no-underline">Shop</a>
                            @if(!empty($category))
                                <span class="text-stone-300">/</span>
                                <span class="text-stone-800 font-medium">{{ $category->name }}</span>
                            @endif
                        </nav>
                    </div>

                    <span class="text-xs text-stone-500 font-medium">
                        Showing <span id="displayedProductsCount"
                            class="font-bold text-stone-800">{{ $products->count() }}</span> of <span
                            id="totalProductsCount" class="font-bold text-stone-800">{{ $totalCount }}</span> items
                    </span>
                </div>
            </div>
        </div>

        <!-- 2. Main Shop Layout -->
        <div class="container mx-auto px-4 max-w-7xl py-6 sm:py-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                <!-- Left: Desktop Sidebar Filters (Cols 3) -->
                <aside class="hidden lg:block lg:col-span-3 space-y-6 sticky top-24">
                    <div class="bg-white rounded-sm border border-stone-200/80 shadow-sm p-5 space-y-6">

                        <!-- Header -->
                        <div class="flex items-center justify-between pb-3.5 border-b border-stone-200/80">
                            <span
                                class="font-serif font-bold text-sm text-stone-900 uppercase tracking-wider flex items-center gap-2">
                                <i class="fa-solid fa-sliders text-[#a28e46] text-xs"></i> Filters
                            </span>
                            <button type="button" onclick="clearAllShopFilters()"
                                class="text-[11px] font-semibold text-stone-400 hover:text-[#a28e46] uppercase tracking-wider transition-colors cursor-pointer focus:outline-none">
                                Clear All
                            </button>
                        </div>

                        <!-- In Stock Quick Toggle -->
                        <div class="flex items-center justify-between py-1 border-b border-stone-100 pb-3.5">
                            <span class="text-xs font-bold text-stone-800 uppercase tracking-wider">In Stock Only</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="filterInStock" class="sr-only peer" {{ !empty($selectedInStock) ? 'checked' : '' }} onchange="applyShopFilters()">
                                <div
                                    class="w-9 h-5 bg-stone-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#a28e46]">
                                </div>
                            </label>
                        </div>



                        <!-- Progressive Dual-Thumb Price Range Slider -->
                        <div class="space-y-4 pb-4 border-b border-stone-100">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-bold text-stone-800 uppercase tracking-wider">Price Range</h4>
                                <span id="priceRangeDisplay" class="text-xs font-mono font-bold text-[#a28e46]">
                                    ৳{{ number_format($curMin) }} - ৳{{ number_format($curMax) }}
                                </span>
                            </div>

                            <!-- Dual Range Slider Container -->
                            <div class="relative py-3">
                                <!-- Track Background -->
                                <div class="w-full h-1.5 bg-stone-200 rounded-full relative">
                                    <!-- Active Fill Progress Bar -->
                                    <div id="priceRangeTrack" class="absolute h-full bg-[#a28e46] rounded-full"
                                        style="left: 0%; right: 0%;"></div>
                                </div>

                                <!-- Left Thumb (Min) Slider -->
                                <input type="range" id="rangeMin" min="0" max="{{ $maxPrice }}" value="{{ $curMin }}"
                                    step="10"
                                    class="dual-range-input absolute inset-x-0 top-1/2 -translate-y-1/2 w-full h-1.5 z-20"
                                    oninput="updatePriceSlider('min')">

                                <!-- Right Thumb (Max) Slider -->
                                <input type="range" id="rangeMax" min="0" max="{{ $maxPrice }}" value="{{ $curMax }}"
                                    step="10"
                                    class="dual-range-input absolute inset-x-0 top-1/2 -translate-y-1/2 w-full h-1.5 z-20"
                                    oninput="updatePriceSlider('max')">
                            </div>

                            <!-- Min & Max Clean Value Boxes (No arrows) -->
                            <div class="grid grid-cols-2 gap-2.5 pt-1">
                                <div
                                    class="bg-stone-50 border border-stone-200 rounded-sm p-2 text-center transition-colors focus-within:border-[#a28e46] focus-within:bg-white shadow-sm">
                                    <span
                                        class="text-[10px] font-bold text-stone-400 block uppercase tracking-wider mb-0.5">Min
                                        (৳)</span>
                                    <input type="number" id="filterPriceMin" value="{{ $curMin }}"
                                        class="no-spinner w-full text-center text-xs font-bold text-stone-900 bg-transparent outline-none"
                                        oninput="syncInputsToSlider()">
                                </div>
                                <div
                                    class="bg-stone-50 border border-stone-200 rounded-sm p-2 text-center transition-colors focus-within:border-[#a28e46] focus-within:bg-white shadow-sm">
                                    <span
                                        class="text-[10px] font-bold text-stone-400 block uppercase tracking-wider mb-0.5">Max
                                        (৳)</span>
                                    <input type="number" id="filterPriceMax" value="{{ $curMax }}"
                                        class="no-spinner w-full text-center text-xs font-bold text-stone-900 bg-transparent outline-none"
                                        oninput="syncInputsToSlider()">
                                </div>
                            </div>

                            <!-- Luxury Theme Apply Button -->
                            <button type="button" onclick="applyShopFilters()"
                                class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest py-2.5 rounded-sm shadow-md hover:shadow-lg transition-all cursor-pointer focus:outline-none active:scale-[0.99] flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-filter text-[10px]"></i>
                                <span>Apply Price Filter</span>
                            </button>
                        </div>

                        <!-- Category Filter -->
                        <div class="space-y-3 pb-3.5 border-b border-stone-100">
                            <h4 class="text-xs font-bold text-stone-800 uppercase tracking-wider">
                                Categories
                            </h4>

                            <div class="space-y-1.5 max-h-60 overflow-y-auto pr-1 scrollbar-thin text-xs text-stone-600">
                                @foreach($categories as $cat)
                                    @php
                                        $isSelected = in_array($cat->slug, $selectedCategories) || (isset($category) && $category->slug === $cat->slug);
                                        $hasChildren = $cat->children && count($cat->children) > 0;
                                    @endphp
                                    <div class="space-y-1">
                                        <label class="flex items-center justify-between py-1 group cursor-pointer select-none">
                                            <span class="flex items-center gap-2">
                                                <input type="checkbox"
                                                    class="rounded border-stone-300 text-[#a28e46] focus:ring-0 cursor-pointer cat-filter-checkbox"
                                                    value="{{ $cat->slug }}" {{ $isSelected ? 'checked' : '' }}
                                                    onchange="applyShopFilters()">
                                                <span
                                                    class="font-medium {{ $isSelected ? 'text-[#a28e46] font-bold' : 'text-stone-700 group-hover:text-[#a28e46]' }} transition-colors">
                                                    {{ $cat->name }}
                                                </span>
                                            </span>
                                            <span
                                                class="text-[10px] text-stone-400 font-mono">({{ $cat->products_count ?? $cat->products()->count() }})</span>
                                        </label>

                                        <!-- Subcategories Tree -->
                                        @if($hasChildren)
                                            <div class="pl-4 space-y-1 border-l-2 border-stone-100 ml-1.5 py-0.5">
                                                @foreach($cat->children as $child)
                                                    @php
                                                        $isChildSelected = in_array($child->slug, $selectedCategories) || (isset($category) && $category->slug === $child->slug);
                                                    @endphp
                                                    <label
                                                        class="flex items-center justify-between py-0.5 group cursor-pointer select-none">
                                                        <span class="flex items-center gap-2">
                                                            <input type="checkbox"
                                                                class="rounded border-stone-300 text-[#a28e46] focus:ring-0 cursor-pointer cat-filter-checkbox"
                                                                value="{{ $child->slug }}" {{ $isChildSelected ? 'checked' : '' }}
                                                                onchange="applyShopFilters()">
                                                            <span
                                                                class="text-stone-600 group-hover:text-[#a28e46] {{ $isChildSelected ? 'text-[#a28e46] font-bold' : '' }} transition-colors">
                                                                {{ $child->name }}
                                                            </span>
                                                        </span>
                                                        <span
                                                            class="text-[10px] text-stone-400 font-mono">({{ $child->products_count ?? $child->products()->count() }})</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Brands Filter -->
                        @if(isset($brands) && count($brands) > 0)
                            <div class="space-y-3">
                                <h4 class="text-xs font-bold text-stone-800 uppercase tracking-wider">
                                    Brands
                                </h4>
                                <div class="space-y-1.5 max-h-48 overflow-y-auto pr-1 scrollbar-thin text-xs text-stone-600">
                                    @foreach($brands as $br)
                                        @php $isBrandSelected = isset($selectedBrands) && in_array($br->id, $selectedBrands); @endphp
                                        <label class="flex items-center justify-between py-1 group cursor-pointer select-none">
                                            <span class="flex items-center gap-2">
                                                <input type="checkbox"
                                                    class="rounded border-stone-300 text-[#a28e46] focus:ring-0 cursor-pointer brand-filter-checkbox"
                                                    value="{{ $br->id }}" {{ $isBrandSelected ? 'checked' : '' }}
                                                    onchange="applyShopFilters()">
                                                <span
                                                    class="font-medium {{ $isBrandSelected ? 'text-[#a28e46] font-bold' : 'text-stone-700 group-hover:text-[#a28e46]' }} transition-colors">
                                                    {{ $br->name }}
                                                </span>
                                            </span>
                                            <span class="text-[10px] text-stone-400 font-mono">({{ $br->products_count }})</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                </aside>

                <!-- Right: Products Showcase & Controls (Cols 9) -->
                <main class="lg:col-span-9 space-y-4">

                    <!-- Toolbar: Mobile Filter Button & Custom Luxury Sort Dropdown -->
                    <div
                        class="bg-white rounded-sm border border-stone-200/80 shadow-sm p-2.5 sm:px-4 sm:py-3 flex items-center justify-between gap-2.5 sm:gap-4">

                        <!-- Mobile Filter Drawer Trigger -->
                        @php
                            $activeFilterCount = count($selectedCategories) + (isset($selectedBrands) ? count($selectedBrands) : 0) + (!empty($selectedInStock) ? 1 : 0);
                        @endphp
                        <button type="button"
                            class="lg:hidden flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-3.5 py-2 bg-stone-50 hover:bg-stone-100 text-stone-800 text-xs font-bold uppercase tracking-wider rounded border border-stone-200 hover:border-[#a28e46] transition-all focus:outline-none cursor-pointer shadow-2xs"
                            onclick="openMobileFilters()">
                            <i class="fa-solid fa-sliders text-[#a28e46]"></i>
                            <span>Filters</span>
                            @if($activeFilterCount > 0)
                                <span
                                    class="bg-[#a28e46] text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-mono font-bold">{{ $activeFilterCount }}</span>
                            @endif
                        </button>

                        <div class="hidden sm:block text-xs text-stone-500">
                            Showing luxury cosmetics catalog
                        </div>

                        <!-- Custom Luxury Sort Dropdown -->
                        <div class="relative flex-1 sm:flex-initial sm:ml-auto" id="customSortDropdownWrap">
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-xs font-semibold text-stone-600 uppercase tracking-wider hidden sm:inline-block">SORT
                                    BY:</span>

                                <!-- Custom Trigger Button -->
                                <button type="button" id="sortTriggerBtn"
                                    class="w-full sm:w-auto inline-flex items-center justify-between gap-2 px-3 sm:px-3.5 py-2 bg-stone-50 hover:bg-white text-stone-800 text-xs font-semibold rounded border border-stone-300 hover:border-[#a28e46] transition-all cursor-pointer focus:outline-none shadow-2xs min-w-0 sm:min-w-[170px]"
                                    onclick="toggleSortDropdown()">
                                    <span id="currentSortLabel" class="truncate">
                                        @if($selectedSort == 'price_low' || $selectedSort == 'lowToHigh') Price: Low to High
                                        @elseif($selectedSort == 'price_high' || $selectedSort == 'highToLow') Price: High
                                            to Low
                                        @elseif($selectedSort == 'popular') Most Popular
                                        @else Newest Arrivals
                                        @endif
                                    </span>
                                    <i class="fa-solid fa-chevron-down text-[10px] text-stone-500 transition-transform duration-200 flex-shrink-0"
                                        id="sortChevron"></i>
                                </button>
                            </div>

                            <!-- Custom Dropdown Menu -->
                            <div id="sortMenuPanel"
                                class="hidden absolute right-0 mt-1.5 w-48 sm:w-52 bg-white rounded border border-stone-200 shadow-xl py-1 z-30 text-xs transition-all">
                                <button type="button"
                                    class="w-full text-left px-3.5 py-2 hover:bg-[#faf7f0] hover:text-[#a28e46] flex items-center justify-between font-medium text-stone-700 cursor-pointer focus:outline-none {{ $selectedSort == 'newest' ? 'text-[#a28e46] font-bold bg-[#faf7f0]' : '' }}"
                                    onclick="selectSortOption('newest', 'Newest Arrivals')">
                                    <span>Newest Arrivals</span>
                                    @if($selectedSort == 'newest') <i
                                    class="fa-solid fa-check text-[10px] text-[#a28e46]"></i> @endif
                                </button>
                                <button type="button"
                                    class="w-full text-left px-3.5 py-2 hover:bg-[#faf7f0] hover:text-[#a28e46] flex items-center justify-between font-medium text-stone-700 cursor-pointer focus:outline-none {{ in_array($selectedSort, ['price_low', 'lowToHigh']) ? 'text-[#a28e46] font-bold bg-[#faf7f0]' : '' }}"
                                    onclick="selectSortOption('price_low', 'Price: Low to High')">
                                    <span>Price: Low to High</span>
                                    @if(in_array($selectedSort, ['price_low', 'lowToHigh'])) <i
                                    class="fa-solid fa-check text-[10px] text-[#a28e46]"></i> @endif
                                </button>
                                <button type="button"
                                    class="w-full text-left px-3.5 py-2 hover:bg-[#faf7f0] hover:text-[#a28e46] flex items-center justify-between font-medium text-stone-700 cursor-pointer focus:outline-none {{ in_array($selectedSort, ['price_high', 'highToLow']) ? 'text-[#a28e46] font-bold bg-[#faf7f0]' : '' }}"
                                    onclick="selectSortOption('price_high', 'Price: High to Low')">
                                    <span>Price: High to Low</span>
                                    @if(in_array($selectedSort, ['price_high', 'highToLow'])) <i
                                    class="fa-solid fa-check text-[10px] text-[#a28e46]"></i> @endif
                                </button>
                                <button type="button"
                                    class="w-full text-left px-3.5 py-2 hover:bg-[#faf7f0] hover:text-[#a28e46] flex items-center justify-between font-medium text-stone-700 cursor-pointer focus:outline-none {{ $selectedSort == 'popular' ? 'text-[#a28e46] font-bold bg-[#faf7f0]' : '' }}"
                                    onclick="selectSortOption('popular', 'Most Popular')">
                                    <span>Most Popular</span>
                                    @if($selectedSort == 'popular') <i
                                    class="fa-solid fa-check text-[10px] text-[#a28e46]"></i> @endif
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Products Grid Container -->
                    <div id="shopProductsContainer" class="min-h-[400px] relative">
                        <!-- Loading Spinner Overlay -->
                        <div id="shopLoadingOverlay"
                            class="absolute inset-0 bg-white/70 backdrop-blur-[1px] z-20 hidden flex items-center justify-center">
                            <div class="w-10 h-10 border-3 border-stone-200 border-t-[#a28e46] rounded-full animate-spin">
                            </div>
                        </div>

                        @include('ecommerce.partials.product-grid')
                    </div>

                </main>

            </div>
        </div>

    </div>

    <!-- Mobile Filter Drawer Modal -->
    <div id="mobileFilterDrawer"
        class="fixed inset-0 bg-black/60 backdrop-blur-[2px] z-[26000] opacity-0 pointer-events-none transition-opacity duration-300 flex">
        <div id="mobileFilterPanel"
            class="w-80 max-w-[85vw] h-full bg-white shadow-2xl flex flex-col transform -translate-x-full transition-transform duration-300 ease-out z-[26001]">

            <!-- Header -->
            <div
                class="p-4 bg-gradient-to-r from-[#a28e46] to-[#8e7b39] text-white flex items-center justify-between shadow-sm flex-shrink-0">
                <span class="font-serif font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-sliders"></i> Filter Products
                </span>
                <button type="button"
                    class="w-7 h-7 rounded-full bg-white/20 text-white flex items-center justify-center cursor-pointer focus:outline-none"
                    onclick="closeMobileFilters()">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>

            <!-- Scrollable Filter Content -->
            <div class="flex-grow overflow-y-auto p-4 space-y-6 text-xs">

                <!-- In Stock Quick Toggle -->
                <div class="flex items-center justify-between py-1 border-b border-stone-100 pb-3">
                    <span class="font-bold text-stone-800 uppercase tracking-wider">In Stock Only</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="mobileFilterInStock" class="sr-only peer" {{ !empty($selectedInStock) ? 'checked' : '' }}>
                        <div
                            class="w-9 h-5 bg-stone-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#a28e46]">
                        </div>
                    </label>
                </div>

                <!-- Price Range Dual-Thumb Progress Bar Slider -->
                <div class="space-y-3 pt-1 border-b border-stone-100 pb-4">
                    <div class="flex items-center justify-between">
                        <h4 class="font-bold text-stone-800 uppercase tracking-wider">Price Range</h4>
                        <span id="mobilePriceRangeDisplay" class="text-xs font-mono font-bold text-[#a28e46]">
                            ৳{{ number_format($curMin) }} - ৳{{ number_format($curMax) }}
                        </span>
                    </div>

                    <!-- Dual Range Slider Container -->
                    <div class="relative py-2.5">
                        <!-- Track Background -->
                        <div class="w-full h-1.5 bg-stone-200 rounded-full relative">
                            <!-- Active Fill Progress Bar -->
                            <div id="mobilePriceRangeTrack" class="absolute h-full bg-[#a28e46] rounded-full"
                                style="left: 0%; right: 0%;"></div>
                        </div>

                        <!-- Left Thumb (Min) Slider -->
                        <input type="range" id="mobileRangeMin" min="0" max="{{ $maxPrice }}" value="{{ $curMin }}"
                            step="10" class="dual-range-input absolute inset-x-0 top-1/2 -translate-y-1/2 w-full h-1.5 z-20"
                            oninput="updateMobilePriceSlider('min')">

                        <!-- Right Thumb (Max) Slider -->
                        <input type="range" id="mobileRangeMax" min="0" max="{{ $maxPrice }}" value="{{ $curMax }}"
                            step="10" class="dual-range-input absolute inset-x-0 top-1/2 -translate-y-1/2 w-full h-1.5 z-20"
                            oninput="updateMobilePriceSlider('max')">
                    </div>

                    <div class="grid grid-cols-2 gap-2 pt-0.5">
                        <div class="bg-stone-50 border border-stone-200 rounded-sm p-1.5 text-center">
                            <span class="text-[9px] font-bold text-stone-400 block uppercase tracking-wider mb-0.5">Min
                                (৳)</span>
                            <input type="number" id="mobilePriceMin" value="{{ $curMin }}"
                                class="no-spinner w-full text-center text-xs font-bold text-stone-900 bg-transparent outline-none"
                                oninput="syncMobileInputsToSlider()">
                        </div>
                        <div class="bg-stone-50 border border-stone-200 rounded-sm p-1.5 text-center">
                            <span class="text-[9px] font-bold text-stone-400 block uppercase tracking-wider mb-0.5">Max
                                (৳)</span>
                            <input type="number" id="mobilePriceMax" value="{{ $curMax }}"
                                class="no-spinner w-full text-center text-xs font-bold text-stone-900 bg-transparent outline-none"
                                oninput="syncMobileInputsToSlider()">
                        </div>
                    </div>
                </div>

                <!-- Category List -->
                <div class="space-y-2 border-b border-stone-100 pb-4">
                    <h4 class="font-bold text-stone-800 uppercase tracking-wider">Categories</h4>
                    <div class="space-y-1.5 max-h-56 overflow-y-auto pr-1">
                        @foreach($categories as $cat)
                            @php 
                                                        $isSelected = in_array($cat->slug, $selectedCategories) || (isset($category) && $category->slug === $cat->slug);
                                $hasChildren = $cat->children && count($cat->children) > 0;
                            @endphp
                            <div class="space-y-1">
                                <label class="flex items-center justify-between py-1 cursor-pointer select-none">
                                    <span class="flex items-center gap-2">
                                        <input type="checkbox"
                                            class="rounded border-stone-300 text-[#a28e46] focus:ring-0 mobile-cat-checkbox"
                                            value="{{ $cat->slug }}" {{ $isSelected ? 'checked' : '' }}>
                                        <span
                                            class="font-medium {{ $isSelected ? 'text-[#a28e46] font-bold' : 'text-stone-700' }}">{{ $cat->name }}</span>
                                    </span>
                                    <span
                                        class="text-[10px] text-stone-400 font-mono">({{ $cat->products_count ?? $cat->products()->count() }})</span>
                                </label>

                                <!-- Mobile Subcategories Tree -->
                                @if($hasChildren)
                                    <div class="pl-4 space-y-1 border-l-2 border-stone-100 ml-1.5 py-0.5">
                                        @foreach($cat->children as $child)
                                            @php $isChildSelected = in_array($child->slug, $selectedCategories) || (isset($category) && $category->slug === $child->slug); @endphp
                                            <label class="flex items-center justify-between py-0.5 cursor-pointer select-none">
                                                <span class="flex items-center gap-2">
                                                    <input type="checkbox"
                                                        class="rounded border-stone-300 text-[#a28e46] focus:ring-0 mobile-cat-checkbox"
                                                        value="{{ $child->slug }}" {{ $isChildSelected ? 'checked' : '' }}>
                                                    <span
                                                        class="{{ $isChildSelected ? 'text-[#a28e46] font-bold' : 'text-stone-600' }}">{{ $child->name }}</span>
                                                </span>
                                                <span
                                                    class="text-[10px] text-stone-400 font-mono">({{ $child->products_count ?? $child->products()->count() }})</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Brands List -->
                @if(isset($brands) && count($brands) > 0)
                    <div class="space-y-2">
                        <h4 class="font-bold text-stone-800 uppercase tracking-wider">Brands</h4>
                        <div class="space-y-1.5 max-h-44 overflow-y-auto pr-1">
                            @foreach($brands as $br)
                                @php $isBrandSelected = isset($selectedBrands) && in_array($br->id, $selectedBrands); @endphp
                                <label class="flex items-center justify-between py-1 cursor-pointer select-none">
                                    <span class="flex items-center gap-2">
                                        <input type="checkbox"
                                            class="rounded border-stone-300 text-[#a28e46] focus:ring-0 mobile-brand-checkbox"
                                            value="{{ $br->id }}" {{ $isBrandSelected ? 'checked' : '' }}>
                                        <span
                                            class="font-medium {{ $isBrandSelected ? 'text-[#a28e46] font-bold' : 'text-stone-700' }}">{{ $br->name }}</span>
                                    </span>
                                    <span class="text-[10px] text-stone-400 font-mono">({{ $br->products_count }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <!-- Sticky Bottom Apply Button -->
            <div class="p-4 bg-stone-50 border-t border-stone-200 flex-shrink-0 space-y-2">
                <button type="button"
                    class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest py-3 px-4 rounded shadow-md transition-colors cursor-pointer focus:outline-none"
                    onclick="applyMobileFiltersAndClose()">
                    APPLY FILTERS
                </button>
                <button type="button" onclick="clearAllShopFilters()"
                    class="w-full text-center text-[11px] font-semibold text-stone-500 hover:text-[#a28e46] uppercase tracking-wider cursor-pointer">
                    Reset All Filters
                </button>
            </div>

        </div>
    </div>

    <script>
        let currentSort = @json($selectedSort ?? 'newest');
        const maxProductPriceLimit = {{ (float) $maxPrice }};

        // Custom Sort Dropdown Handler
        function toggleSortDropdown() {
            const menu = document.getElementById('sortMenuPanel');
            const chevron = document.getElementById('sortChevron');
            if (!menu) return;
            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                if (chevron) chevron.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        }

        function selectSortOption(sortVal, label) {
            currentSort = sortVal;
            const labelEl = document.getElementById('currentSortLabel');
            if (labelEl) labelEl.textContent = label;

            const menu = document.getElementById('sortMenuPanel');
            if (menu) menu.classList.add('hidden');
            const chevron = document.getElementById('sortChevron');
            if (chevron) chevron.classList.remove('rotate-180');

            applyShopFilters();
        }

        // Close sort dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const wrap = document.getElementById('customSortDropdownWrap');
            if (wrap && !wrap.contains(e.target)) {
                const menu = document.getElementById('sortMenuPanel');
                const chevron = document.getElementById('sortChevron');
                if (menu) menu.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        });

        // Dual Range Slider Sync
        function updatePriceSlider(source) {
            const rMin = document.getElementById('rangeMin');
            const rMax = document.getElementById('rangeMax');
            const inMin = document.getElementById('filterPriceMin');
            const inMax = document.getElementById('filterPriceMax');
            const track = document.getElementById('priceRangeTrack');
            const display = document.getElementById('priceRangeDisplay');

            if (!rMin || !rMax) return;

            let minVal = parseInt(rMin.value) || 0;
            let maxVal = parseInt(rMax.value) || 0;

            const minGap = 10;
            if (maxVal - minVal < minGap) {
                if (source === 'min') {
                    minVal = Math.max(0, maxVal - minGap);
                    rMin.value = minVal;
                } else if (source === 'max') {
                    maxVal = Math.min(maxProductPriceLimit, minVal + minGap);
                    rMax.value = maxVal;
                }
            }

            if (inMin) inMin.value = minVal;
            if (inMax) inMax.value = maxVal;

            const leftPct = Math.min(100, Math.max(0, (minVal / maxProductPriceLimit) * 100));
            const rightPct = Math.min(100, Math.max(0, 100 - ((maxVal / maxProductPriceLimit) * 100)));

            if (track) {
                track.style.left = `${leftPct}%`;
                track.style.right = `${rightPct}%`;
            }

            if (display) {
                display.textContent = `৳${minVal.toLocaleString()} - ৳${maxVal.toLocaleString()}`;
            }
        }

        function syncInputsToSlider() {
            const inMin = document.getElementById('filterPriceMin');
            const inMax = document.getElementById('filterPriceMax');
            const rMin = document.getElementById('rangeMin');
            const rMax = document.getElementById('rangeMax');

            if (!inMin || !inMax || !rMin || !rMax) return;

            let minVal = parseInt(inMin.value) || 0;
            let maxVal = parseInt(inMax.value) || maxProductPriceLimit;

            if (minVal < 0) minVal = 0;
            if (maxVal > maxProductPriceLimit) maxVal = maxProductPriceLimit;

            rMin.value = minVal;
            rMax.value = maxVal;
            updatePriceSlider();
        }

        // Mobile Dual Range Slider Sync
        function updateMobilePriceSlider(source) {
            const rMin = document.getElementById('mobileRangeMin');
            const rMax = document.getElementById('mobileRangeMax');
            const inMin = document.getElementById('mobilePriceMin');
            const inMax = document.getElementById('mobilePriceMax');
            const track = document.getElementById('mobilePriceRangeTrack');
            const display = document.getElementById('mobilePriceRangeDisplay');

            if (!rMin || !rMax) return;

            let minVal = parseInt(rMin.value) || 0;
            let maxVal = parseInt(rMax.value) || 0;

            const minGap = 10;
            if (maxVal - minVal < minGap) {
                if (source === 'min') {
                    minVal = Math.max(0, maxVal - minGap);
                    rMin.value = minVal;
                } else if (source === 'max') {
                    maxVal = Math.min(maxProductPriceLimit, minVal + minGap);
                    rMax.value = maxVal;
                }
            }

            if (inMin) inMin.value = minVal;
            if (inMax) inMax.value = maxVal;

            const leftPct = Math.min(100, Math.max(0, (minVal / maxProductPriceLimit) * 100));
            const rightPct = Math.min(100, Math.max(0, 100 - ((maxVal / maxProductPriceLimit) * 100)));

            if (track) {
                track.style.left = `${leftPct}%`;
                track.style.right = `${rightPct}%`;
            }

            if (display) {
                display.textContent = `৳${minVal.toLocaleString()} - ৳${maxVal.toLocaleString()}`;
            }
        }

        function syncMobileInputsToSlider() {
            const inMin = document.getElementById('mobilePriceMin');
            const inMax = document.getElementById('mobilePriceMax');
            const rMin = document.getElementById('mobileRangeMin');
            const rMax = document.getElementById('mobileRangeMax');

            if (!inMin || !inMax || !rMin || !rMax) return;

            let minVal = parseInt(inMin.value) || 0;
            let maxVal = parseInt(inMax.value) || maxProductPriceLimit;

            if (minVal < 0) minVal = 0;
            if (maxVal > maxProductPriceLimit) maxVal = maxProductPriceLimit;

            rMin.value = minVal;
            rMax.value = maxVal;
            updateMobilePriceSlider();
        }

        // Open & Close Mobile Filter Drawer
        window.openMobileFilters = function () {
            const overlay = document.getElementById('mobileFilterDrawer');
            const panel = document.getElementById('mobileFilterPanel');
            if (!overlay || !panel) return;
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100', 'pointer-events-auto');
            panel.classList.remove('-translate-x-full');
            panel.classList.add('translate-x-0');
            document.body.style.overflow = 'hidden';
        };

        window.closeMobileFilters = function (e) {
            if (e && e.target && e.target.id !== 'mobileFilterDrawer') return;
            const overlay = document.getElementById('mobileFilterDrawer');
            const panel = document.getElementById('mobileFilterPanel');
            if (!overlay || !panel) return;
            panel.classList.remove('translate-x-0');
            panel.classList.add('-translate-x-full');
            overlay.classList.remove('opacity-100', 'pointer-events-auto');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = '';
        };

        document.getElementById('mobileFilterDrawer')?.addEventListener('click', window.closeMobileFilters);

        function applyMobileFiltersAndClose() {
            const minVal = document.getElementById('mobilePriceMin').value;
            const maxVal = document.getElementById('mobilePriceMax').value;
            document.getElementById('filterPriceMin').value = minVal;
            document.getElementById('filterPriceMax').value = maxVal;
            syncInputsToSlider();

            const mobileInStock = document.getElementById('mobileFilterInStock')?.checked || false;
            const desktopInStock = document.getElementById('filterInStock');
            if (desktopInStock) desktopInStock.checked = mobileInStock;

            const mobileCats = Array.from(document.querySelectorAll('.mobile-cat-checkbox:checked')).map(cb => cb.value);
            document.querySelectorAll('.cat-filter-checkbox').forEach(cb => {
                cb.checked = mobileCats.includes(cb.value);
            });

            const mobileBrands = Array.from(document.querySelectorAll('.mobile-brand-checkbox:checked')).map(cb => cb.value);
            document.querySelectorAll('.brand-filter-checkbox').forEach(cb => {
                cb.checked = mobileBrands.includes(cb.value);
            });

            closeMobileFilters();
            applyShopFilters();
        }

        // Clear All Filters
        window.clearAllShopFilters = function () {
            document.querySelectorAll('.cat-filter-checkbox, .mobile-cat-checkbox, .brand-filter-checkbox, .mobile-brand-checkbox').forEach(cb => cb.checked = false);
            const inStock = document.getElementById('filterInStock');
            if (inStock) inStock.checked = false;
            const mobileInStock = document.getElementById('mobileFilterInStock');
            if (mobileInStock) mobileInStock.checked = false;

            const inMin = document.getElementById('filterPriceMin');
            const inMax = document.getElementById('filterPriceMax');
            if (inMin) inMin.value = 0;
            if (inMax) inMax.value = maxProductPriceLimit;
            syncInputsToSlider();

            currentSort = 'newest';
            const labelEl = document.getElementById('currentSortLabel');
            if (labelEl) labelEl.textContent = 'Newest Arrivals';

            applyShopFilters();
        };

        // Handle AJAX Pagination
        window.handleShopPagination = async function (e, targetUrl) {
            if (e) e.preventDefault();
            if (!targetUrl) return;

            let targetPage = 1;
            try {
                const urlObj = new URL(targetUrl, window.location.origin);
                targetPage = urlObj.searchParams.get('page') || 1;
            } catch (err) {
                const match = targetUrl.match(/page=(\d+)/);
                if (match) targetPage = match[1];
            }

            const selectedCats = Array.from(document.querySelectorAll('.cat-filter-checkbox:checked')).map(cb => cb.value);
            const selectedBrands = Array.from(document.querySelectorAll('.brand-filter-checkbox:checked')).map(cb => cb.value);
            const inStock = document.getElementById('filterInStock')?.checked ? '1' : '';
            const priceMin = document.getElementById('filterPriceMin')?.value || '';
            const priceMax = document.getElementById('filterPriceMax')?.value || '';

            const params = new URLSearchParams();
            selectedCats.forEach(c => params.append('categories[]', c));
            selectedBrands.forEach(b => params.append('brands[]', b));
            if (inStock) params.set('in_stock', '1');
            if (priceMin && priceMin > 0) params.set('price_min', priceMin);
            if (priceMax && priceMax < maxProductPriceLimit) params.set('price_max', priceMax);
            if (currentSort) params.set('sort', currentSort);
            params.set('page', targetPage);

            const newUrl = `/products?${params.toString()}`;
            window.history.pushState({}, '', newUrl);

            const loading = document.getElementById('shopLoadingOverlay');
            if (loading) loading.classList.remove('hidden');

            try {
                const res = await fetch(newUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();
                if (data && data.html) {
                    const container = document.getElementById('shopProductsContainer');
                    if (container) {
                        container.innerHTML = `<div id="shopLoadingOverlay" class="absolute inset-0 bg-white/70 backdrop-blur-[1px] z-20 hidden flex items-center justify-center"><div class="w-10 h-10 border-3 border-stone-200 border-t-[#a28e46] rounded-full animate-spin"></div></div>` + data.html;
                    }

                    const dispCount = document.getElementById('displayedProductsCount');
                    const totCount = document.getElementById('totalProductsCount');
                    if (dispCount && data.count !== undefined) dispCount.textContent = data.count;
                    if (totCount && data.total !== undefined) totCount.textContent = data.total;

                    // Smooth scroll up to top of grid
                    const mainArea = document.getElementById('shopProductsContainer');
                    if (mainArea) {
                        mainArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                } else {
                    window.location.href = newUrl;
                }
            } catch (err) {
                console.error('Pagination error:', err);
                window.location.href = newUrl;
            } finally {
                if (loading) loading.classList.add('hidden');
            }
        };

        // Apply Filters with Smooth AJAX Refresh
        window.applyShopFilters = async function () {
            const loading = document.getElementById('shopLoadingOverlay');
            if (loading) loading.classList.remove('hidden');

            const selectedCats = Array.from(document.querySelectorAll('.cat-filter-checkbox:checked')).map(cb => cb.value);
            const selectedBrands = Array.from(document.querySelectorAll('.brand-filter-checkbox:checked')).map(cb => cb.value);
            const inStock = document.getElementById('filterInStock')?.checked ? '1' : '';
            const priceMin = document.getElementById('filterPriceMin')?.value || '';
            const priceMax = document.getElementById('filterPriceMax')?.value || '';

            const params = new URLSearchParams();
            selectedCats.forEach(c => params.append('categories[]', c));
            selectedBrands.forEach(b => params.append('brands[]', b));
            if (inStock) params.set('in_stock', '1');
            if (priceMin && priceMin > 0) params.set('price_min', priceMin);
            if (priceMax && priceMax < maxProductPriceLimit) params.set('price_max', priceMax);
            if (currentSort) params.set('sort', currentSort);

            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.pushState({}, '', newUrl);

            try {
                const res = await fetch(newUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();
                if (data && data.html) {
                    const container = document.getElementById('shopProductsContainer');
                    if (container) {
                        container.innerHTML = `<div id="shopLoadingOverlay" class="absolute inset-0 bg-white/70 backdrop-blur-[1px] z-20 hidden flex items-center justify-center"><div class="w-10 h-10 border-3 border-stone-200 border-t-[#a28e46] rounded-full animate-spin"></div></div>` + data.html;
                    }
                    const dispCount = document.getElementById('displayedProductsCount');
                    const totCount = document.getElementById('totalProductsCount');
                    if (dispCount && data.count !== undefined) dispCount.textContent = data.count;
                    if (totCount && data.total !== undefined) totCount.textContent = data.total;
                } else {
                    window.location.reload();
                }
            } catch (e) {
                console.error('Filter error:', e);
                window.location.href = newUrl;
            } finally {
                if (loading) loading.classList.add('hidden');
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            updatePriceSlider();
        });
    </script>
@endsection