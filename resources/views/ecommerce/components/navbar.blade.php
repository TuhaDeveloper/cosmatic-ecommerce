<!-- Topbar & Header Dropdown CSS -->
<style>
    .harosa-topbar {
        position: relative !important;
        z-index: 1000 !important;
        overflow: visible !important;
    }
    .topbar-dropdown-wrap {
        position: relative !important;
        display: inline-block !important;
    }
    .topbar-dropdown-wrap:hover > .topbar-dropdown-menu,
    .topbar-dropdown-wrap:focus-within > .topbar-dropdown-menu,
    .topbar-dropdown-menu.show-menu {
        opacity: 1 !important;
        visibility: visible !important;
        pointer-events: auto !important;
        transform: translateY(0) !important;
    }
    .topbar-dropdown-menu {
        position: absolute !important;
        right: 0 !important;
        top: 100% !important;
        padding-top: 6px !important;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease !important;
        transform: translateY(6px);
        z-index: 999999 !important;
    }
    .topbar-dropdown-menu::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        height: 10px !important;
    }
    .header-user-wrap {
        position: relative !important;
        display: inline-block !important;
    }
    .header-user-wrap:hover > .header-user-dropdown,
    .header-user-wrap:focus-within > .header-user-dropdown,
    .header-user-dropdown.show-menu {
        opacity: 1 !important;
        visibility: visible !important;
        pointer-events: auto !important;
        transform: translateY(0) !important;
    }
    .header-user-dropdown {
        position: absolute !important;
        right: 0 !important;
        top: 100% !important;
        padding-top: 6px !important;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease !important;
        transform: translateY(6px);
        z-index: 999999 !important;
    }
    .header-user-dropdown::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        height: 10px !important;
    }
    .topbar-dropdown-menu a {
        color: #374151 !important;
        display: flex !important;
        align-items: center !important;
        text-decoration: none !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    .topbar-dropdown-menu a:hover {
        color: #a28e46 !important;
        background-color: #faf7f0 !important;
    }
    .topbar-dropdown-menu a i,
    .topbar-dropdown-menu a span {
        color: inherit !important;
    }
    .header-user-dropdown a {
        color: #374151 !important;
        display: flex !important;
        align-items: center !important;
        text-decoration: none !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    .header-user-dropdown a:hover {
        color: #a28e46 !important;
        background-color: #faf7f0 !important;
    }
    .header-user-dropdown a i,
    .header-user-dropdown a span {
        color: inherit !important;
    }
</style>

<!-- Harosa Top Bar -->
<div class="harosa-topbar hidden lg:block bg-[#a28e46] text-white py-2 text-xs">
    <div class="container mx-auto px-4 max-w-7xl flex items-center justify-between">
        <!-- Left: Contact & Socials -->
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-4 text-white/95">
                <a href="tel:{{ $general_settings->contact_phone ?? '012800456789' }}" class="text-white hover:text-white/80 transition-colors flex items-center gap-1.5 no-underline">
                    <i class="fa-solid fa-phone-volume text-[11px]"></i>
                    <span>Call Us : {{ $general_settings->contact_phone ?? '(012) 800 456 789' }}</span>
                </a>
                <span class="text-white/40">|</span>
                <a href="mailto:{{ $general_settings->contact_email ?? 'demo@example.com' }}" class="text-white hover:text-white/80 transition-colors flex items-center gap-1.5 no-underline">
                    <i class="fa-solid fa-envelope text-[11px]"></i>
                    <span>Email : {{ $general_settings->contact_email ?? 'Demo@Example.Com' }}</span>
                </a>
            </div>

            <div class="flex items-center gap-3 text-white/90">
                @if($general_settings && $general_settings->facebook_url)
                    <a href="{{ $general_settings->facebook_url }}" target="_blank" class="hover:text-white transition-colors" title="Facebook"><i class="fa-brands fa-facebook-f text-xs"></i></a>
                @else
                    <a href="#" class="hover:text-white transition-colors"><i class="fa-brands fa-facebook-f text-xs"></i></a>
                @endif

                @if($general_settings && $general_settings->x_url)
                    <a href="{{ $general_settings->x_url }}" target="_blank" class="hover:text-white transition-colors" title="Twitter / X"><i class="fa-brands fa-twitter text-xs"></i></a>
                @else
                    <a href="#" class="hover:text-white transition-colors"><i class="fa-brands fa-twitter text-xs"></i></a>
                @endif

                @if($general_settings && $general_settings->youtube_url)
                    <a href="{{ $general_settings->youtube_url }}" target="_blank" class="hover:text-white transition-colors" title="YouTube"><i class="fa-brands fa-youtube text-xs"></i></a>
                @else
                    <a href="#" class="hover:text-white transition-colors"><i class="fa-brands fa-youtube text-xs"></i></a>
                @endif

                @if($general_settings && $general_settings->instagram_url)
                    <a href="{{ $general_settings->instagram_url }}" target="_blank" class="hover:text-white transition-colors" title="Instagram"><i class="fa-brands fa-instagram text-xs"></i></a>
                @else
                    <a href="#" class="hover:text-white transition-colors"><i class="fa-brands fa-instagram text-xs"></i></a>
                @endif
            </div>
        </div>

        <!-- Right: Account, Currency, Language -->
        <div class="flex items-center gap-5">
            <!-- Account Dropdown -->
            <div class="relative group topbar-dropdown-wrap">
                <button type="button" class="text-white hover:text-white/80 transition-colors flex items-center gap-1.5 focus:outline-none cursor-pointer py-1" onclick="toggleTopbarMenu(this)">
                    <i class="fa-regular fa-user text-xs"></i>
                    <span>My Account</span>
                    <i class="fa-solid fa-chevron-down text-[9px] opacity-80"></i>
                </button>
                <div class="topbar-dropdown-menu absolute right-0 top-full pt-2 w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-[9999]">
                    <div class="bg-white text-stone-800 rounded-sm shadow-2xl border border-stone-200 py-1.5">
                        @guest
                            <a href="{{ route('login') }}" style="color: #374151 !important;" class="flex items-center gap-2.5 px-4 py-2 text-xs hover:bg-[#faf7f0] hover:text-[#a28e46] transition-colors no-underline">
                                <i class="fa-solid fa-right-to-bracket text-xs w-4" style="color: #a28e46;"></i>
                                <span style="color: #374151;">Login</span>
                            </a>
                            <a href="{{ route('register') }}" style="color: #374151 !important;" class="flex items-center gap-2.5 px-4 py-2 text-xs hover:bg-[#faf7f0] hover:text-[#a28e46] transition-colors no-underline">
                                <i class="fa-solid fa-user-plus text-xs w-4" style="color: #a28e46;"></i>
                                <span style="color: #374151;">Register</span>
                            </a>
                        @else
                            <div class="px-4 py-1.5 border-b border-stone-100 mb-1">
                                <div class="font-bold text-xs text-stone-900 truncate">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                                <div class="text-[10px] text-stone-400 truncate">{{ Auth::user()->email }}</div>
                            </div>
                            <a href="{{ route('profile.edit') }}" style="color: #374151 !important;" class="flex items-center gap-2.5 px-4 py-2 text-xs hover:bg-[#faf7f0] hover:text-[#a28e46] transition-colors no-underline">
                                <i class="fa-regular fa-id-badge text-xs w-4" style="color: #a28e46;"></i>
                                <span style="color: #374151;">My Profile</span>
                            </a>
                            <a href="{{ route('profile.edit', ['tab' => 'orders']) }}" style="color: #374151 !important;" class="flex items-center gap-2.5 px-4 py-2 text-xs hover:bg-[#faf7f0] hover:text-[#a28e46] transition-colors no-underline">
                                <i class="fa-solid fa-bag-shopping text-xs w-4" style="color: #a28e46;"></i>
                                <span style="color: #374151;">My Orders</span>
                            </a>
                            <a href="{{ route('wishlist.index') }}" style="color: #374151 !important;" class="flex items-center gap-2.5 px-4 py-2 text-xs hover:bg-[#faf7f0] hover:text-[#a28e46] transition-colors no-underline">
                                <i class="fa-regular fa-heart text-xs w-4" style="color: #a28e46;"></i>
                                <span style="color: #374151;">Wishlist</span>
                            </a>
                            <div class="border-t border-stone-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 transition-colors bg-transparent border-0 cursor-pointer">
                                        <i class="fa-solid fa-right-from-bracket text-xs w-4"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Header Section -->
<header class="bg-white py-4 lg:py-6 border-b border-gray-100">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex items-center justify-between gap-4">
            <!-- Brand Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center gap-2 no-underline text-gray-900 group">
                    @if($general_settings && $general_settings->site_logo)
                        <img src="{{ asset($general_settings->site_logo) }}" alt="{{ $general_settings->site_title ?? 'Harosa' }}" class="h-10 md:h-14 w-auto object-contain block" width="150" height="56" decoding="sync" fetchpriority="high" loading="eager">
                    @else
                        <div class="flex items-center gap-2">
                            <span class="text-3xl text-[#a28e46]"><i class="fa-solid fa-spa"></i></span>
                            <span class="font-serif text-3xl md:text-4xl font-bold tracking-tight text-[#a28e46] italic group-hover:opacity-90 transition-opacity">Harosa</span>
                        </div>
                    @endif
                </a>
            </div>

            <!-- Search Bar (Desktop) -->
            <div class="hidden md:flex flex-grow max-w-xl mx-6">
                <form action="{{ route('search') }}" method="get" class="w-full flex items-center bg-[#faf8f5] border border-stone-200 hover:border-[#a28e46]/70 focus-within:border-[#a28e46] focus-within:bg-white rounded-full transition-all duration-200 shadow-xs focus-within:shadow-md" style="padding: 4px 6px 4px 22px !important;">
                    <span class="flex items-center text-stone-400 flex-shrink-0" style="margin-right: 12px;">
                        <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 17px; height: 17px;">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                    <input type="text" name="search" placeholder="Search for cosmetics, brands, skincare..." class="flex-grow text-xs md:text-sm text-stone-800 bg-transparent !border-0 !outline-none !ring-0 focus:!ring-0 focus:!outline-none placeholder:text-stone-400 font-normal" style="outline: none !important; border: none !important; box-shadow: none !important; background: transparent !important; padding: 6px 4px !important;">
                    <button type="submit" class="bg-[#a28e46] hover:bg-[#8e7b39] text-white text-xs font-semibold uppercase tracking-wider rounded-full transition-all duration-200 flex items-center justify-center flex-shrink-0 cursor-pointer shadow-xs active:scale-95" style="padding: 7px 22px !important; border: none !important;">
                        Search
                    </button>
                </form>
            </div>

            <!-- Header Actions / Cart / Account -->
            <div class="flex items-center gap-1.5 sm:gap-2.5 lg:gap-4">
                <!-- Mobile Search Toggle -->
                <button type="button" id="mobileSearchToggle" class="md:hidden w-10 h-10 rounded-full flex items-center justify-center text-stone-700 hover:text-[#a28e46] hover:bg-stone-100 active:scale-95 transition-all focus:outline-none cursor-pointer" aria-label="Toggle search">
                    <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>

                <!-- Desktop Account / User -->
                @auth
                    <div class="header-user-wrap hidden sm:block">
                        <a href="{{ route('profile.edit') }}" class="flex items-center justify-center w-10 h-10 rounded-full text-stone-700 hover:text-[#a28e46] hover:bg-[#faf7f0] active:scale-95 transition-all no-underline" title="My Account">
                            <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </a>

                        <!-- Dropdown Menu -->
                        <div class="header-user-dropdown w-52">
                            <div class="bg-white text-stone-800 rounded-sm shadow-2xl border border-stone-200 py-2">
                            <div class="px-4 py-2 border-b border-stone-100 mb-1">
                                <div class="font-bold text-xs text-stone-900 truncate">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                                <div class="text-[10px] text-stone-400 truncate">{{ Auth::user()->email }}</div>
                            </div>
                            <a href="{{ route('profile.edit') }}" style="color: #374151 !important;" class="flex items-center gap-2.5 px-4 py-2 text-xs hover:bg-[#faf7f0] hover:text-[#a28e46] transition-colors no-underline">
                                <i class="fa-regular fa-user text-xs w-4" style="color: #a28e46;"></i>
                                <span style="color: #374151;">My Profile</span>
                            </a>
                            <a href="{{ route('profile.edit', ['tab' => 'orders']) }}" style="color: #374151 !important;" class="flex items-center gap-2.5 px-4 py-2 text-xs hover:bg-[#faf7f0] hover:text-[#a28e46] transition-colors no-underline">
                                <i class="fa-solid fa-bag-shopping text-xs w-4" style="color: #a28e46;"></i>
                                <span style="color: #374151;">My Orders</span>
                            </a>
                            <a href="{{ route('wishlist.index') }}" style="color: #374151 !important;" class="flex items-center gap-2.5 px-4 py-2 text-xs hover:bg-[#faf7f0] hover:text-[#a28e46] transition-colors no-underline">
                                <i class="fa-regular fa-heart text-xs w-4" style="color: #a28e46;"></i>
                                <span style="color: #374151;">Wishlist</span>
                            </a>
                            <div class="border-t border-stone-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 transition-colors bg-transparent border-0 cursor-pointer">
                                        <i class="fa-solid fa-right-from-bracket text-xs w-4"></i>
                                        <span>Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:flex items-center justify-center w-10 h-10 rounded-full text-stone-700 hover:text-[#a28e46] hover:bg-[#faf7f0] active:scale-95 transition-all no-underline" title="Login / Register">
                        <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </a>
                @endauth

                <!-- Wishlist Icon (Desktop) -->
                <a href="{{ route('wishlist.index') }}" class="hidden sm:flex items-center justify-center w-10 h-10 rounded-full text-stone-700 hover:text-[#a28e46] hover:bg-[#faf7f0] active:scale-95 transition-all no-underline relative" title="Wishlist">
                    <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                    <span class="badge nav-wishlist-count absolute top-1 right-1 bg-[#a28e46] text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold border border-white shadow-xs">0</span>
                </a>

                <!-- Cart Widget (Harosa Luxury Bag) -->
                <a href="#" onclick="openOffcanvasCart(); return false;" class="flex items-center gap-2 text-stone-800 hover:text-[#a28e46] transition-colors no-underline group select-none cursor-pointer p-1.5 rounded-full hover:bg-[#faf7f0]" title="Shopping Bag">
                    <div class="relative text-[#a28e46] group-hover:scale-105 transition-transform flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="badge nav-cart-count absolute -top-1.5 -right-2 bg-[#a28e46] text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold border-2 border-white shadow-xs">0</span>
                    </div>
                    <div class="hidden sm:flex flex-col text-left leading-tight pr-1">
                        <span class="text-[9px] text-stone-400 uppercase tracking-wider font-semibold">Shopping Bag</span>
                        <span class="text-xs text-stone-800 font-bold font-mono"><span class="nav-cart-count">0</span> Items</span>
                    </div>
                </a>

                <!-- Mobile Menu Hamburger (Luxury Minimalist 3-Line SVG) -->
                <button type="button" id="mobileMenuToggle" class="lg:hidden w-10 h-10 rounded-full flex items-center justify-center text-stone-800 hover:text-[#a28e46] hover:bg-stone-100 active:scale-95 transition-all focus:outline-none cursor-pointer" aria-label="Open mobile menu">
                    <svg class="w-6 h-6 stroke-current" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" y1="7" x2="20" y2="7"></line>
                        <line x1="4" y1="12" x2="20" y2="12"></line>
                        <line x1="4" y1="17" x2="20" y2="17"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Navigation & Categories Bar (Harosa Luxury Navigation) -->
<nav class="hidden lg:block bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex items-center">
            <!-- Categories Left Column Header with Hover Dropdown -->
            <div class="w-64 flex-shrink-0 harosa-cat-menu-wrap">
                <a href="{{ route('categories') }}" class="bg-[#a28e46] hover:bg-[#8e7b39] text-white font-semibold text-xs tracking-wider uppercase px-5 py-3.5 flex items-center justify-between transition-colors no-underline rounded-t-sm">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                        <span>CATEGORIES</span>
                    </div>
                    <svg class="w-3.5 h-3.5 stroke-current fill-none transition-transform duration-200" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>

                @php
                    $catsList = (isset($nav_categories) && count($nav_categories) > 0) ? $nav_categories : ((isset($categories) && count($categories) > 0) ? $categories : []);
                @endphp

                <!-- Hover Dropdown Menu -->
                <div class="harosa-cat-dropdown absolute top-full left-0 w-64 bg-white border border-stone-200 shadow-2xl z-50 rounded-b-sm">
                    <ul class="list-none p-0 m-0 divide-y divide-stone-100 text-xs font-medium text-gray-700">
                        @if(count($catsList) > 0)
                            @foreach($catsList->take(12) as $cat)
                                @php
                                    $hasChildren = $cat->children && $cat->children->count() > 0;
                                @endphp
                                <li class="harosa-cat-item">
                                    <a href="{{ route('product.archive') }}?category={{ $cat->slug }}" 
                                       class="flex items-center justify-between px-5 py-3 text-gray-800 hover:text-[#a28e46] hover:bg-[#fbf9f4] transition-colors uppercase tracking-wider font-semibold no-underline text-[11.5px]">
                                        <span class="truncate pr-2">{{ $cat->name }}</span>
                                        @if($hasChildren)
                                            <svg class="w-3 h-3 stroke-current text-gray-400 fill-none" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="9 18 15 12 9 6"></polyline>
                                            </svg>
                                        @endif
                                    </a>

                                    @if($hasChildren)
                                        <!-- Harosa Subcategory Mega Menu Flyout -->
                                        <div class="harosa-mega-flyout absolute top-0 left-full ml-1 min-w-[500px] max-w-[650px] bg-white border border-stone-200/90 shadow-2xl rounded-sm p-6 z-50">
                                            <div class="absolute top-4 -left-2 w-0 h-0 border-y-8 border-y-transparent border-r-8 border-r-white"></div>
                                            
                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 text-left">
                                                @foreach($cat->children as $subcat)
                                                    @php
                                                        $hasGrandChildren = $subcat->children && $subcat->children->count() > 0;
                                                    @endphp
                                                    <div class="space-y-2">
                                                        <a href="{{ route('product.archive') }}?category={{ $subcat->slug }}" 
                                                           class="font-serif font-bold text-xs md:text-sm text-gray-900 hover:text-[#a28e46] uppercase tracking-wider block pb-1.5 border-b border-stone-200 no-underline">
                                                            {{ $subcat->name }}
                                                        </a>

                                                        @if($hasGrandChildren)
                                                            <ul class="list-none p-0 m-0 space-y-1.5 pt-1">
                                                                @foreach($subcat->children as $grandchild)
                                                                    <li>
                                                                        <a href="{{ route('product.archive') }}?category={{ $grandchild->slug }}" 
                                                                           class="text-xs text-gray-600 hover:text-[#a28e46] transition-colors block py-0.5 no-underline font-normal">
                                                                            {{ $grandchild->name }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        @else
                            <li class="px-5 py-4 text-gray-400 italic">No categories found</li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Horizontal Main Nav Links -->
            <div class="flex-grow flex items-center pl-6">
                <ul class="flex items-center gap-1 mb-0 list-none pl-0">
                    <li>
                        <a href="/" class="harosa-nav-link {{ request()->is('/') ? 'active' : '' }}">
                            <span>HOME</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('product.archive') }}" class="harosa-nav-link {{ request()->is('products*') ? 'active' : '' }}">
                            <span>SHOP</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('best.deal') }}" class="harosa-nav-link {{ request()->is('best-deal*') ? 'active' : '' }}">
                            <span>BEST DEALS</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('vlogs') }}" class="harosa-nav-link {{ request()->is('vlogs*') ? 'active' : '' }}">
                            <span>COLLECTIONS</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="harosa-nav-link {{ request()->is('about*') ? 'active' : '' }}">
                            <span>ABOUT US</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="harosa-nav-link {{ request()->is('contact*') ? 'active' : '' }}">
                            <span>CONTACT</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Search Bar Drawer (Luxury Slide-Down with Clean Borderless Input) -->
<div class="mobile-searchbar hidden md:hidden bg-white/95 backdrop-blur-md py-2.5 px-3.5 border-b border-stone-200/90 shadow-lg transition-all duration-200 z-50" id="mobileSearchBar">
    <form action="{{ route('search') }}" method="get" class="flex items-center gap-2 m-0">
        <div class="flex-grow flex items-center bg-stone-100 rounded-full px-3.5 py-1.5 transition-all">
            <svg class="w-4 h-4 stroke-stone-400 fill-none mr-2 flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" 
                   name="search" 
                   id="mobileSearchInput" 
                   placeholder="Search products, brands, categories..." 
                   class="w-full text-xs text-stone-800 bg-transparent !border-0 !border-none !outline-none !shadow-none !ring-0 focus:!ring-0 focus:!outline-none focus:!border-none placeholder:text-stone-400 p-0"
                   style="outline: none !important; border: none !important; box-shadow: none !important; -webkit-tap-highlight-color: transparent;">
            <button type="button" id="mobileSearchClearBtn" class="hidden text-stone-400 hover:text-stone-600 text-xs p-1 focus:outline-none cursor-pointer flex-shrink-0" onclick="clearMobileSearch()">
                <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </button>
        </div>
        <button type="submit" class="bg-[#a28e46] hover:bg-[#8e7b39] text-white text-xs font-bold uppercase px-3.5 py-2 rounded-full shadow-xs flex items-center justify-center flex-shrink-0 active:scale-95 transition-transform cursor-pointer !border-0">
            Search
        </button>
        <button type="button" class="text-stone-500 hover:text-stone-800 text-xs font-semibold px-1 py-1.5 focus:outline-none flex-shrink-0 cursor-pointer !border-0" onclick="closeMobileSearch()">
            Cancel
        </button>
    </form>
</div>

<!-- Mobile Menu Overlay & Drawer -->
<div class="fixed inset-0 bg-black/60 backdrop-blur-[2px] z-[99998] transition-opacity hidden" id="mobileOverlay"></div>
<aside class="fixed top-0 left-0 bottom-0 w-80 max-w-[85vw] bg-white z-[99999] shadow-2xl flex flex-col transform -translate-x-full transition-transform duration-300 ease-out" id="mobileNav">
    <!-- Header -->
    <div class="p-3.5 bg-gradient-to-r from-[#a28e46] to-[#8e7b39] text-white flex items-center justify-between shadow-sm flex-shrink-0">
        <a href="/" class="flex items-center no-underline">
            @if($general_settings && $general_settings->site_logo)
                <img src="{{ asset($general_settings->site_logo) }}" alt="{{ $general_settings->site_title ?? 'Logo' }}" class="h-9 max-h-9 w-auto object-contain bg-white px-2.5 py-1 rounded-sm shadow-sm">
            @else
                <span class="font-serif font-bold text-base tracking-wide uppercase text-white">{{ $general_settings->site_title ?? 'Sisal Fashion' }}</span>
            @endif
        </a>
        <button type="button" class="w-8 h-8 rounded-full bg-white/15 hover:bg-white/30 text-white flex items-center justify-center transition-colors focus:outline-none cursor-pointer" id="mobileMenuClose" aria-label="Close menu">
            <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <!-- Mobile Drawer Tab Switcher -->
    <div class="grid grid-cols-2 bg-stone-100 p-1 border-b border-stone-200 flex-shrink-0">
        <button type="button" id="mobileTabBtnCategories" class="py-2.5 text-xs font-bold uppercase tracking-wider rounded-sm text-stone-900 bg-white shadow-sm transition-all focus:outline-none flex items-center justify-center gap-1.5 cursor-pointer" onclick="switchMobileTab('categories')">
            <svg class="w-3.5 h-3.5 stroke-[#a28e46] fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="8" y1="6" x2="21" y2="6"></line>
                <line x1="8" y1="12" x2="21" y2="12"></line>
                <line x1="8" y1="18" x2="21" y2="18"></line>
                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>
            <span>Categories</span>
        </button>
        <button type="button" id="mobileTabBtnMenu" class="py-2.5 text-xs font-bold uppercase tracking-wider rounded-sm text-stone-500 hover:text-stone-900 transition-all focus:outline-none flex items-center justify-center gap-1.5 cursor-pointer" onclick="switchMobileTab('menu')">
            <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
            <span>Main Menu</span>
        </button>
    </div>

    <!-- Tab Contents (Scrollable) -->
    <div class="flex-grow overflow-y-auto p-4 space-y-4">
        
        <!-- Tab: Categories -->
        <div id="mobileTabContentCategories" class="space-y-1">
            @php
                $mobileCats = (isset($nav_categories) && count($nav_categories) > 0) ? $nav_categories : ((isset($categories) && count($categories) > 0) ? $categories : []);
            @endphp

            @if(count($mobileCats) > 0)
                @foreach($mobileCats as $cat)
                    @php
                        $hasChildren = $cat->children && $cat->children->count() > 0;
                    @endphp
                    <div class="border-b border-stone-100 last:border-0 pb-1">
                        <div class="flex items-center justify-between py-2.5">
                            <a href="{{ route('product.archive') }}?category={{ $cat->slug }}" class="text-xs font-bold text-stone-800 hover:text-[#a28e46] uppercase tracking-wider no-underline truncate pr-2">
                                {{ $cat->name }}
                            </a>
                            @if($hasChildren)
                                <button type="button" class="w-8 h-8 flex items-center justify-center text-stone-400 hover:text-[#a28e46] transition-colors focus:outline-none cursor-pointer" onclick="toggleMobileAccordion(this)">
                                    <svg class="w-3 h-3 stroke-current fill-none transition-transform duration-200" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                            @endif
                        </div>

                        @if($hasChildren)
                            <div class="hidden pl-3 pb-2 space-y-1.5 border-l-2 border-[#a28e46]/30 ml-2">
                                @foreach($cat->children as $subcat)
                                    <a href="{{ route('product.archive') }}?category={{ $subcat->slug }}" class="block py-1 text-xs text-stone-600 hover:text-[#a28e46] no-underline font-medium">
                                        • {{ $subcat->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-xs text-stone-400 italic py-4">No categories found</div>
            @endif
        </div>

        <!-- Tab: Main Menu -->
        <div id="mobileTabContentMenu" class="hidden space-y-1">
            <!-- User Status -->
            <div class="mb-4 pb-3 border-b border-stone-200">
                @auth
                    <div class="p-2.5 rounded bg-stone-50 border border-stone-200/80 mb-2">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-[#a28e46] text-white flex items-center justify-center font-serif font-bold text-xs">
                                    {{ strtoupper(substr(Auth::user()->first_name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-bold text-xs text-stone-900 truncate">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                                    <div class="text-[10px] text-stone-400 truncate">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-1.5 pt-2 border-t border-stone-200 text-center">
                            <a href="{{ route('profile.edit') }}" class="py-1.5 px-2 text-[11px] font-bold text-stone-700 hover:text-[#a28e46] bg-white rounded border border-stone-200 no-underline">
                                <i class="fa-regular fa-user text-[10px] me-1"></i> Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="w-full py-1.5 px-2 text-[11px] font-bold text-rose-600 hover:bg-rose-50 bg-white rounded border border-stone-200 cursor-pointer">
                                    <i class="fa-solid fa-right-from-bracket text-[10px] me-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('login') }}" class="text-center py-2 px-3 text-xs font-bold uppercase tracking-wider bg-[#a28e46] text-white rounded-sm no-underline shadow-sm">Login</a>
                        <a href="{{ route('register') }}" class="text-center py-2 px-3 text-xs font-bold uppercase tracking-wider border border-[#a28e46] text-[#a28e46] rounded-sm no-underline">Register</a>
                    </div>
                @endauth
            </div>

            <a href="/" class="flex items-center gap-3 px-3 py-2.5 rounded text-xs font-bold uppercase tracking-wider text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 no-underline">
                <svg class="w-4 h-4 stroke-[#a28e46] fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Home</span>
            </a>
            <a href="{{ route('product.archive') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-xs font-bold uppercase tracking-wider text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 no-underline">
                <svg class="w-4 h-4 stroke-[#a28e46] fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                <span>Shop All</span>
            </a>
            <a href="{{ route('best.deal') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-xs font-bold uppercase tracking-wider text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 no-underline">
                <svg class="w-4 h-4 stroke-[#a28e46] fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                </svg>
                <span>Best Deals</span>
            </a>
            <a href="{{ route('vlogs') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-xs font-bold uppercase tracking-wider text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 no-underline">
                <svg class="w-4 h-4 stroke-[#a28e46] fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="23 7 16 12 23 17 23 7"></polygon>
                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                </svg>
                <span>Collections</span>
            </a>
            <a href="{{ route('about') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-xs font-bold uppercase tracking-wider text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 no-underline">
                <svg class="w-4 h-4 stroke-[#a28e46] fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                <span>About Us</span>
            </a>
            <a href="{{ route('contact') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-xs font-bold uppercase tracking-wider text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 no-underline">
                <svg class="w-4 h-4 stroke-[#a28e46] fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                <span>Contact Us</span>
            </a>
        </div>

    </div>

    <!-- Drawer Footer -->
    <div class="p-4 bg-stone-50 border-t border-stone-200 text-center flex-shrink-0">
        <a href="tel:{{ $general_settings->contact_phone ?? '012800456789' }}" class="text-xs font-bold text-stone-700 hover:text-[#a28e46] flex items-center justify-center gap-2 no-underline">
            <svg class="w-4 h-4 stroke-[#a28e46] fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
            </svg>
            <span>Hotline: {{ $general_settings->contact_phone ?? '012800456789' }}</span>
        </a>
    </div>
</aside>

<!-- Sticky Bottom Mobile Navigation Bar (Aarong / Sephora Real-World Luxury Pattern) -->
<div class="md:hidden fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-stone-200/80 shadow-[0_-4px_16px_rgba(0,0,0,0.06)] z-[15000] px-3 py-1.5 flex items-center justify-around">
    <a href="/" class="flex flex-col items-center justify-center text-center {{ request()->is('/') ? 'text-[#a28e46]' : 'text-stone-500' }} hover:text-[#a28e46] active:scale-95 transition-all no-underline py-1">
        <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="{{ request()->is('/') ? '2.2' : '1.8' }}" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        <span class="text-[10px] font-semibold mt-1">Home</span>
    </a>
    <button type="button" onclick="openDrawerWithTab('categories')" class="flex flex-col items-center justify-center text-center text-stone-500 hover:text-[#a28e46] active:scale-95 transition-all bg-transparent border-0 p-0 cursor-pointer focus:outline-none py-1">
        <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
            <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
            <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
            <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
        </svg>
        <span class="text-[10px] font-semibold mt-1">Categories</span>
    </button>
    <a href="{{ route('best.deal') }}" class="flex flex-col items-center justify-center text-center {{ request()->is('best-deal*') ? 'text-[#a28e46]' : 'text-stone-500' }} hover:text-[#a28e46] active:scale-95 transition-all no-underline py-1">
        <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="{{ request()->is('best-deal*') ? '2.2' : '1.8' }}" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
            <line x1="7" y1="7" x2="7.01" y2="7"></line>
        </svg>
        <span class="text-[10px] font-semibold mt-1">Deals</span>
    </a>
    <a href="{{ route('wishlist.index') }}" class="flex flex-col items-center justify-center text-center {{ request()->is('wishlist*') ? 'text-[#a28e46]' : 'text-stone-500' }} hover:text-[#a28e46] active:scale-95 transition-all no-underline relative py-1">
        <div class="relative flex items-center justify-center">
            <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="{{ request()->is('wishlist*') ? '2.2' : '1.8' }}" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
            <span class="badge nav-wishlist-count absolute -top-1.5 -right-2 bg-[#a28e46] text-white text-[9px] font-bold w-3.5 h-3.5 rounded-full flex items-center justify-center border border-white">0</span>
        </div>
        <span class="text-[10px] font-semibold mt-1">Wishlist</span>
    </a>
    <button type="button" onclick="openOffcanvasCart()" class="flex flex-col items-center justify-center text-center text-stone-500 hover:text-[#a28e46] active:scale-95 transition-all bg-transparent border-0 p-0 cursor-pointer focus:outline-none relative py-1">
        <div class="relative flex items-center justify-center">
            <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span class="badge nav-cart-count absolute -top-1.5 -right-2 bg-[#a28e46] text-white text-[9px] font-bold w-3.5 h-3.5 rounded-full flex items-center justify-center border border-white">0</span>
        </div>
        <span class="text-[10px] font-semibold mt-1">Bag</span>
    </button>
</div>

<script>
    (function(){
        document.addEventListener('DOMContentLoaded', function() {
            const drawer = document.getElementById('mobileNav');
            const overlay = document.getElementById('mobileOverlay');
            if (drawer && drawer.parentElement !== document.body) {
                document.body.appendChild(drawer);
            }
            if (overlay && overlay.parentElement !== document.body) {
                document.body.appendChild(overlay);
            }
        });

        const toggle = document.getElementById('mobileMenuToggle');
        const drawer = document.getElementById('mobileNav');
        const overlay = document.getElementById('mobileOverlay');
        const closeBtn = document.getElementById('mobileMenuClose');
        const searchToggle = document.getElementById('mobileSearchToggle');
        const searchBar = document.getElementById('mobileSearchBar');

        function openDrawer() {
            if (!drawer || !overlay) return;
            overlay.classList.remove('hidden');
            drawer.classList.remove('-translate-x-full');
            drawer.classList.add('translate-x-0');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            if (!drawer || !overlay) return;
            drawer.classList.remove('translate-x-0');
            drawer.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        window.openDrawerWithTab = function(tabName) {
            openDrawer();
            switchMobileTab(tabName);
        };

        function openMobileSearch() {
            if (!searchBar) return;
            searchBar.classList.remove('hidden');
            const input = document.getElementById('mobileSearchInput');
            if (input) {
                setTimeout(() => input.focus(), 50);
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function closeMobileSearch() {
            if (!searchBar) return;
            searchBar.classList.add('hidden');
        }

        window.toggleMobileSearch = function(e) {
            if (e) e.stopPropagation();
            if (!searchBar) return;
            if (searchBar.classList.contains('hidden')) {
                openMobileSearch();
            } else {
                closeMobileSearch();
            }
        };

        window.closeMobileSearch = closeMobileSearch;

        window.clearMobileSearch = function() {
            const input = document.getElementById('mobileSearchInput');
            const clearBtn = document.getElementById('mobileSearchClearBtn');
            if (input) {
                input.value = '';
                input.focus();
            }
            if (clearBtn) clearBtn.classList.add('hidden');
        };

        // Real-world: Click outside anywhere on document to close mobile search
        document.addEventListener('click', function(e) {
            if (!searchBar || searchBar.classList.contains('hidden')) return;
            const isClickInside = searchBar.contains(e.target) || (searchToggle && searchToggle.contains(e.target));
            if (!isClickInside) {
                closeMobileSearch();
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchBar && !searchBar.classList.contains('hidden')) {
                closeMobileSearch();
            }
        });

        // Toggle clear (X) icon when typing in search input
        const mobileInput = document.getElementById('mobileSearchInput');
        const clearBtn = document.getElementById('mobileSearchClearBtn');
        if (mobileInput && clearBtn) {
            mobileInput.addEventListener('input', function() {
                if (this.value.trim().length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            });
        }

        window.switchMobileTab = function(tab) {
            const catBtn = document.getElementById('mobileTabBtnCategories');
            const menuBtn = document.getElementById('mobileTabBtnMenu');
            const catContent = document.getElementById('mobileTabContentCategories');
            const menuContent = document.getElementById('mobileTabContentMenu');

            if (tab === 'categories') {
                catBtn.classList.add('bg-white', 'text-stone-900', 'shadow-sm');
                catBtn.classList.remove('text-stone-500');
                menuBtn.classList.remove('bg-white', 'text-stone-900', 'shadow-sm');
                menuBtn.classList.add('text-stone-500');
                catContent.classList.remove('hidden');
                menuContent.classList.add('hidden');
            } else {
                menuBtn.classList.add('bg-white', 'text-stone-900', 'shadow-sm');
                menuBtn.classList.remove('text-stone-500');
                catBtn.classList.remove('bg-white', 'text-stone-900', 'shadow-sm');
                catBtn.classList.add('text-stone-500');
                menuContent.classList.remove('hidden');
                catContent.classList.add('hidden');
            }
        };

        window.toggleMobileAccordion = function(btn) {
            const container = btn.closest('.border-b').querySelector('.border-l-2');
            const icon = btn.querySelector('i');
            if (container) {
                container.classList.toggle('hidden');
                if (icon) {
                    icon.classList.toggle('rotate-180');
                }
            }
        };

        if (toggle) toggle.addEventListener('click', openDrawer);
        if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
        if (overlay) overlay.addEventListener('click', closeDrawer);
        if (searchToggle && searchBar) searchToggle.addEventListener('click', toggleMobileSearch);

        // Topbar Dropdowns Toggle on Click
        window.toggleTopbarMenu = function(btn) {
            const wrap = btn.closest('.topbar-dropdown-wrap');
            if (!wrap) return;
            const menu = wrap.querySelector('.topbar-dropdown-menu');
            if (!menu) return;
            
            const isOpen = menu.classList.contains('!opacity-100') && menu.classList.contains('!visible');
            
            // Close all open topbar menus
            document.querySelectorAll('.topbar-dropdown-menu').forEach(m => {
                m.classList.remove('!opacity-100', '!visible');
            });

            if (!isOpen) {
                menu.classList.add('!opacity-100', '!visible');
            }
        };

        // Close topbar menus on outside click
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.topbar-dropdown-wrap')) {
                document.querySelectorAll('.topbar-dropdown-menu').forEach(m => {
                    m.classList.remove('!opacity-100', '!visible');
                });
            }
        });

        window.closeDrawer = closeDrawer;
    })();
</script>

@include('ecommerce.components.offcanvas-cart')