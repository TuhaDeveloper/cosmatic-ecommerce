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
            <div class="relative group">
                <button type="button" class="text-white hover:text-white/80 transition-colors flex items-center gap-1.5 focus:outline-none cursor-pointer">
                    <i class="fa-regular fa-user text-xs"></i>
                    <span>My Account</span>
                    <i class="fa-solid fa-chevron-down text-[9px] opacity-80"></i>
                </button>
                <div class="absolute right-0 top-full mt-1.5 w-48 bg-white text-gray-800 rounded-sm shadow-xl border border-gray-100 py-1.5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    @guest
                        <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2 text-xs hover:bg-[#faf7f0] hover:text-[#a28e46] transition-colors no-underline text-gray-700">
                            <i class="fa-solid fa-right-to-bracket w-4"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center gap-2 px-4 py-2 text-xs hover:bg-[#faf7f0] hover:text-[#a28e46] transition-colors no-underline text-gray-700">
                            <i class="fa-solid fa-user-plus w-4"></i> Register
                        </a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-xs hover:bg-[#faf7f0] hover:text-[#a28e46] transition-colors no-underline text-gray-700">
                            <i class="fa-solid fa-id-card w-4"></i> Profile
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs hover:bg-[#faf7f0] hover:text-[#a28e46] transition-colors no-underline text-gray-700">
                            <i class="fa-regular fa-heart w-4"></i> Wishlist
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-xs hover:bg-[#faf7f0] hover:text-[#a28e46] transition-colors bg-transparent border-0 text-gray-700 cursor-pointer">
                                <i class="fa-solid fa-right-from-bracket w-4"></i> Logout
                            </button>
                        </form>
                    @endguest
                </div>
            </div>

            <!-- Currency -->
            <div class="relative group">
                <button type="button" class="text-white hover:text-white/80 transition-colors flex items-center gap-1 focus:outline-none cursor-pointer">
                    <span>$ USD</span>
                    <i class="fa-solid fa-chevron-down text-[9px] opacity-80"></i>
                </button>
                <div class="absolute right-0 top-full mt-1.5 w-24 bg-white text-gray-800 rounded-sm shadow-xl border border-gray-100 py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <span class="block px-3 py-1.5 text-xs text-gray-700 font-medium bg-[#faf7f0]">$ USD</span>
                    <span class="block px-3 py-1.5 text-xs text-gray-500 hover:text-[#a28e46] cursor-pointer">৳ BDT</span>
                </div>
            </div>

            <!-- Language -->
            <div class="relative group">
                <button type="button" class="text-white hover:text-white/80 transition-colors flex items-center gap-1.5 focus:outline-none cursor-pointer">
                    <span>🇬🇧 English</span>
                    <i class="fa-solid fa-chevron-down text-[9px] opacity-80"></i>
                </button>
                <div class="absolute right-0 top-full mt-1.5 w-28 bg-white text-gray-800 rounded-sm shadow-xl border border-gray-100 py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <span class="block px-3 py-1.5 text-xs text-gray-700 font-medium bg-[#faf7f0]">🇬🇧 English</span>
                    <span class="block px-3 py-1.5 text-xs text-gray-500 hover:text-[#a28e46] cursor-pointer">🇧🇩 Bangla</span>
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
            <div class="hidden md:flex flex-grow max-w-xl mx-4">
                <form action="{{ route('search') }}" method="get" class="w-full flex rounded-full border border-[#a28e46] overflow-hidden shadow-sm hover:shadow-md transition-shadow bg-white">
                    <input type="text" name="search" placeholder="Your email address or search products..." class="flex-grow px-5 py-2.5 text-sm text-gray-800 bg-transparent border-none outline-none focus:ring-0 focus:outline-none placeholder:text-gray-400">
                    <button type="submit" class="bg-[#a28e46] hover:bg-[#8e7b39] text-white px-7 py-2.5 text-xs font-bold uppercase tracking-wider transition-colors duration-200 flex items-center justify-center">
                        SEARCH
                    </button>
                </form>
            </div>

            <!-- Header Actions / Cart -->
            <div class="flex items-center gap-4 lg:gap-6">
                <!-- Mobile Search Toggle -->
                <button type="button" id="mobileSearchToggle" class="md:hidden text-gray-700 hover:text-[#a28e46] text-xl p-1.5 focus:outline-none" aria-label="Toggle search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <!-- Wishlist Icon (Desktop) -->
                <a href="{{ route('wishlist.index') }}" class="hidden sm:flex items-center gap-1.5 text-gray-700 hover:text-[#a28e46] transition-colors no-underline relative" title="Wishlist">
                    <div class="relative text-[#a28e46]">
                        <svg class="w-6 h-6 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                        <span class="badge nav-wishlist-count absolute -top-1.5 -right-2 bg-[#a28e46] text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold border border-white">0</span>
                    </div>
                </a>

                <!-- Cart Widget (Harosa Style Real-world Luxury Bag) -->
                <a href="#" onclick="openOffcanvasCart(); return false;" class="flex items-center gap-2.5 text-gray-800 hover:text-[#a28e46] transition-colors no-underline group select-none cursor-pointer" title="Shopping Bag">
                    <div class="relative text-[#a28e46] group-hover:scale-105 transition-transform flex items-center justify-center">
                        <svg class="w-6 h-6 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="badge nav-cart-count absolute -top-1.5 -right-2.5 bg-[#a28e46] text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold border-2 border-white shadow-xs">0</span>
                    </div>
                    <div class="hidden sm:flex flex-col text-left leading-tight">
                        <span class="text-[10px] text-stone-400 uppercase tracking-wider font-semibold">Shopping Bag</span>
                        <span class="text-xs text-stone-800 font-bold font-mono"><span class="nav-cart-count">0</span> Items</span>
                    </div>
                </a>

                <!-- Mobile Menu Hamburger -->
                <button type="button" id="mobileMenuToggle" class="lg:hidden text-gray-800 hover:text-[#a28e46] text-2xl p-1 focus:outline-none" aria-label="Open mobile menu">
                    <i class="fa-solid fa-bars"></i>
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
                        <i class="fa-solid fa-bars text-sm"></i>
                        <span>CATEGORIES</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
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
                                            <i class="fa-solid fa-chevron-right text-[10px] text-gray-400 transition-transform"></i>
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

<!-- Mobile Search Bar Drawer -->
<div class="mobile-searchbar hidden md:hidden bg-white py-3 px-4 border-b border-gray-200" id="mobileSearchBar">
    <form action="{{ route('search') }}" method="get" class="flex rounded-full border border-[#a28e46] overflow-hidden bg-white shadow-sm">
        <input type="text" name="search" placeholder="Search products..." class="flex-grow px-4 py-2 text-sm text-gray-800 bg-transparent border-none outline-none focus:ring-0 placeholder:text-gray-400">
        <button type="submit" class="bg-[#a28e46] text-white px-5 py-2 text-xs font-bold uppercase">
            <i class="fa-solid fa-magnifying-glass"></i>
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
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>

    <!-- Mobile Drawer Tab Switcher -->
    <div class="grid grid-cols-2 bg-stone-100 p-1 border-b border-stone-200 flex-shrink-0">
        <button type="button" id="mobileTabBtnCategories" class="py-2.5 text-xs font-bold uppercase tracking-wider rounded-sm text-stone-900 bg-white shadow-sm transition-all focus:outline-none" onclick="switchMobileTab('categories')">
            <i class="fa-solid fa-list-ul mr-1.5 text-[#a28e46]"></i> Categories
        </button>
        <button type="button" id="mobileTabBtnMenu" class="py-2.5 text-xs font-bold uppercase tracking-wider rounded-sm text-stone-500 hover:text-stone-900 transition-all focus:outline-none" onclick="switchMobileTab('menu')">
            <i class="fa-solid fa-bars mr-1.5"></i> Main Menu
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
                                <button type="button" class="w-8 h-8 flex items-center justify-center text-stone-400 hover:text-[#a28e46] transition-colors focus:outline-none" onclick="toggleMobileAccordion(this)">
                                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
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
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-2 rounded bg-stone-50 text-stone-800 no-underline">
                        <div class="w-9 h-9 rounded-full bg-[#a28e46] text-white flex items-center justify-center font-bold text-sm">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <div>
                            <div class="font-bold text-xs">{{ Auth::user()->first_name ?? 'My Profile' }}</div>
                            <div class="text-[10px] text-stone-500">View Account</div>
                        </div>
                    </a>
                @else
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('login') }}" class="text-center py-2 px-3 text-xs font-bold uppercase tracking-wider bg-[#a28e46] text-white rounded-sm no-underline shadow-sm">Login</a>
                        <a href="{{ route('register') }}" class="text-center py-2 px-3 text-xs font-bold uppercase tracking-wider border border-[#a28e46] text-[#a28e46] rounded-sm no-underline">Register</a>
                    </div>
                @endauth
            </div>

            <a href="/" class="flex items-center gap-3 px-3 py-2.5 rounded text-xs font-bold uppercase tracking-wider text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 no-underline">
                <i class="fa-solid fa-house w-4 text-[#a28e46]"></i> Home
            </a>
            <a href="{{ route('product.archive') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-xs font-bold uppercase tracking-wider text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 no-underline">
                <i class="fa-solid fa-store w-4 text-[#a28e46]"></i> Shop All
            </a>
            <a href="{{ route('best.deal') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-xs font-bold uppercase tracking-wider text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 no-underline">
                <i class="fa-solid fa-tag w-4 text-[#a28e46]"></i> Best Deals
            </a>
            <a href="{{ route('vlogs') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-xs font-bold uppercase tracking-wider text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 no-underline">
                <i class="fa-solid fa-video w-4 text-[#a28e46]"></i> Collections
            </a>
            <a href="{{ route('about') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-xs font-bold uppercase tracking-wider text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 no-underline">
                <i class="fa-solid fa-circle-info w-4 text-[#a28e46]"></i> About Us
            </a>
            <a href="{{ route('contact') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-xs font-bold uppercase tracking-wider text-stone-700 hover:text-[#a28e46] hover:bg-stone-50 no-underline">
                <i class="fa-solid fa-envelope w-4 text-[#a28e46]"></i> Contact Us
            </a>
        </div>

    </div>

    <!-- Drawer Footer -->
    <div class="p-4 bg-stone-50 border-t border-stone-200 text-center flex-shrink-0">
        <a href="tel:{{ $general_settings->contact_phone ?? '012800456789' }}" class="text-xs font-bold text-stone-700 hover:text-[#a28e46] flex items-center justify-center gap-2 no-underline">
            <i class="fa-solid fa-phone-volume text-[#a28e46]"></i> Hotline: {{ $general_settings->contact_phone ?? '012800456789' }}
        </a>
    </div>
</aside>

<!-- Sticky Bottom Mobile Navigation Bar (Aarong / Sephora Real-World Pattern) -->
<div class="md:hidden fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-stone-200 shadow-[0_-2px_10px_rgba(0,0,0,0.06)] z-[15000] px-3 py-2 flex items-center justify-around">
    <a href="/" class="flex flex-col items-center text-center {{ request()->is('/') ? 'text-[#a28e46]' : 'text-stone-500' }} hover:text-[#a28e46] transition-colors no-underline">
        <i class="fa-solid fa-house text-base"></i>
        <span class="text-[10px] font-semibold mt-0.5">Home</span>
    </a>
    <button type="button" onclick="openDrawerWithTab('categories')" class="flex flex-col items-center text-center text-stone-500 hover:text-[#a28e46] transition-colors bg-transparent border-0 p-0 cursor-pointer focus:outline-none">
        <i class="fa-solid fa-layer-group text-base"></i>
        <span class="text-[10px] font-semibold mt-0.5">Categories</span>
    </button>
    <button type="button" onclick="toggleMobileSearch()" class="flex flex-col items-center text-center text-stone-500 hover:text-[#a28e46] transition-colors bg-transparent border-0 p-0 cursor-pointer focus:outline-none">
        <i class="fa-solid fa-magnifying-glass text-base"></i>
        <span class="text-[10px] font-semibold mt-0.5">Search</span>
    </button>
    <a href="{{ route('wishlist.index') }}" class="flex flex-col items-center text-center {{ request()->is('wishlist*') ? 'text-[#a28e46]' : 'text-stone-500' }} hover:text-[#a28e46] transition-colors no-underline relative">
        <div class="relative">
            <i class="fa-regular fa-heart text-base"></i>
            <span class="nav-wishlist-count absolute -top-1.5 -right-2 bg-[#a28e46] text-white text-[9px] font-bold w-3.5 h-3.5 rounded-full flex items-center justify-center">0</span>
        </div>
        <span class="text-[10px] font-semibold mt-0.5">Wishlist</span>
    </a>
    <button type="button" onclick="openOffcanvasCart()" class="flex flex-col items-center text-center text-stone-500 hover:text-[#a28e46] transition-colors bg-transparent border-0 p-0 cursor-pointer focus:outline-none relative">
        <div class="relative">
            <i class="fa-solid fa-bag-shopping text-base"></i>
            <span class="nav-cart-count absolute -top-1.5 -right-2 bg-[#a28e46] text-white text-[9px] font-bold w-3.5 h-3.5 rounded-full flex items-center justify-center border border-white">0</span>
        </div>
        <span class="text-[10px] font-semibold mt-0.5">Bag</span>
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

        window.toggleMobileSearch = function() {
            if (searchBar) {
                searchBar.classList.toggle('hidden');
                if (!searchBar.classList.contains('hidden')) {
                    searchBar.querySelector('input')?.focus();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        };

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

        if (searchToggle && searchBar) {
            searchToggle.addEventListener('click', toggleMobileSearch);
        }

        window.closeDrawer = closeDrawer;
    })();
</script>

@include('ecommerce.components.offcanvas-cart')