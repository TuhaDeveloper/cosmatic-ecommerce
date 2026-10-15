@extends('ecommerce.master')

@section('title', 'My Account - Harosa Luxury Cosmetics')

@section('main-section')
<div class="bg-stone-50/60 min-h-screen pb-16 sm:pb-20">

    <!-- 1. Editorial Hero Header -->
    <div class="bg-gradient-to-r from-[#111111] via-[#1c1917] to-[#262013] text-white py-8 sm:py-14 relative overflow-hidden border-b border-[#a28e46]/30">
        <!-- Ambient Blur Glows -->
        <div class="absolute -top-24 -right-24 w-72 sm:w-96 h-72 sm:h-96 bg-[#a28e46]/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-64 sm:w-80 h-64 sm:h-80 bg-[#a28e46]/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="container mx-auto px-4 max-w-7xl relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                
                <!-- Left: Avatar & User Info -->
                <div class="flex items-center gap-3.5 sm:gap-6">
                    <!-- Avatar with Verified Badge -->
                    <div class="relative flex-shrink-0 w-16 h-16 sm:w-20 sm:h-20">
                        @php
                            $userInitials = strtoupper(substr($user->first_name ?? 'U', 0, 1) . substr($user->last_name ?? '', 0, 1));
                        @endphp
                        @if(!empty($user->avatar))
                            <img src="{{ $user->avatar }}" alt="{{ $user->first_name }}" class="w-full h-full rounded-full object-cover ring-2 ring-[#a28e46] ring-offset-2 ring-offset-[#1c1917] shadow-lg">
                        @else
                            <div class="w-full h-full rounded-full bg-gradient-to-br from-[#a28e46] to-[#6d5d28] ring-2 ring-[#a28e46] ring-offset-2 ring-offset-[#1c1917] shadow-lg flex items-center justify-center text-white font-serif font-bold text-lg sm:text-2xl tracking-wider">
                                {{ $userInitials ?: 'TM' }}
                            </div>
                        @endif
                        <span class="absolute bottom-0 right-0 bg-[#a28e46] text-white w-5 h-5 sm:w-6 sm:h-6 rounded-full flex items-center justify-center text-[9px] sm:text-[10px] shadow-sm border-2 border-[#1c1917]" title="Verified Client">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </div>

                    <!-- User Name & Meta -->
                    <div class="min-w-0 flex-1">
                        <div class="inline-flex items-center gap-1.5 bg-[#a28e46]/20 border border-[#a28e46]/40 text-[#d4af37] px-2.5 py-0.5 text-[9px] sm:text-[10px] font-bold uppercase tracking-widest rounded-full mb-1 sm:mb-1.5 shadow-xs">
                            <i class="fa-solid fa-crown text-[8px] sm:text-[9px]"></i>
                            <span>Harosa Member</span>
                        </div>
                        <h1 class="font-serif text-xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-white uppercase truncate mb-1">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </h1>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3 text-xs text-stone-300 font-light">
                            <span class="flex items-center gap-1.5 truncate">
                                <i class="fa-regular fa-envelope text-[#a28e46] text-xs flex-shrink-0"></i>
                                <span class="truncate">{{ $user->email }}</span>
                            </span>
                            <span class="text-stone-600 hidden sm:inline">•</span>
                            <span class="flex items-center gap-1.5 text-stone-400">
                                <i class="fa-regular fa-calendar text-[#a28e46] text-xs flex-shrink-0"></i>
                                <span>Member since {{ $user->created_at ? $user->created_at->format('M Y') : 'Recent' }}</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right: Quick Stat Chips & Breadcrumbs -->
                <div class="flex flex-col sm:flex-row lg:flex-col lg:items-end justify-between sm:items-center gap-3 pt-2 sm:pt-0 border-t border-white/10 lg:border-t-0">
                    <div class="grid grid-cols-2 gap-2.5 sm:gap-3 w-full sm:w-auto">
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-sm px-3.5 py-2 text-center min-w-[90px] sm:min-w-[105px]">
                            <span class="block font-serif text-base sm:text-lg font-bold text-[#d4af37] leading-tight">{{ $allOrders->count() }}</span>
                            <span class="text-[9px] sm:text-[10px] text-stone-400 uppercase tracking-wider font-semibold">Total Orders</span>
                        </div>
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-sm px-3.5 py-2 text-center min-w-[90px] sm:min-w-[105px]">
                            <span class="block font-serif text-base sm:text-lg font-bold text-emerald-400 leading-tight">{{ $allOrders->where('status', 'delivered')->count() }}</span>
                            <span class="text-[9px] sm:text-[10px] text-stone-400 uppercase tracking-wider font-semibold">Delivered</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <nav class="flex items-center gap-2 text-xs text-stone-400" aria-label="Breadcrumb">
                            <a href="/" class="hover:text-[#a28e46] transition-colors no-underline text-stone-400">Home</a>
                            <span class="text-stone-600">/</span>
                            <span class="text-white font-medium">My Account</span>
                        </nav>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 hover:bg-rose-600/90 text-stone-200 hover:text-white border border-white/20 hover:border-rose-500 rounded-sm text-[11px] font-semibold uppercase tracking-wider transition-all duration-200 cursor-pointer shadow-xs">
                                <i class="fa-solid fa-right-from-bracket text-[10px]"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Main Content Container -->
    <div class="container mx-auto px-3.5 sm:px-4 max-w-7xl -mt-4 sm:-mt-8 relative z-20">
        
        <!-- Feedback Alerts -->
        @if (session('status') === 'profile-updated')
            <div class="mb-4 sm:mb-6 p-3.5 sm:p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-sm text-xs font-medium flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm flex-shrink-0"></i>
                    <span>Your profile details have been successfully updated.</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @elseif (session('status') === 'password-updated')
            <div class="mb-4 sm:mb-6 p-3.5 sm:p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-sm text-xs font-medium flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-shield-check text-emerald-600 text-sm flex-shrink-0"></i>
                    <span>Your password has been changed successfully.</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @elseif (session('error'))
            <div class="mb-4 sm:mb-6 p-3.5 sm:p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-sm text-xs font-medium flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-sm flex-shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @elseif (session('success'))
            <div class="mb-4 sm:mb-6 p-3.5 sm:p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-sm text-xs font-medium flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm flex-shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 sm:mb-6 p-3.5 sm:p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-sm text-xs font-medium shadow-sm">
                <div class="flex items-center gap-2.5 mb-2 font-bold">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-sm flex-shrink-0"></i>
                    <span>Please correct the errors below:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-rose-700 pl-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card Wrapper with Luxury Tab Navigation -->
        <div class="bg-white border border-stone-200/90 rounded-sm shadow-sm overflow-hidden">
            
            <!-- Luxury Tab Bar (3-Column Grid Responsive) -->
            <div class="border-b border-stone-200 bg-[#faf8f5]">
                <ul class="grid grid-cols-3 text-center font-serif text-[11px] sm:text-xs font-bold uppercase tracking-wider" id="profileTabs" role="tablist">
                    <li role="presentation">
                        <button class="w-full py-3.5 sm:py-4 px-1.5 sm:px-4 transition-all duration-200 flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 border-b-2 cursor-pointer focus:outline-none {{ request()->get('tab') == 'profile' || !request()->has('tab') ? 'border-[#a28e46] text-[#a28e46] bg-white font-bold shadow-xs' : 'border-transparent text-stone-500 hover:text-[#a28e46] hover:bg-stone-100/50 font-semibold' }}"
                                id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="{{ request()->get('tab') == 'profile' || !request()->has('tab') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-user text-xs"></i>
                            <span class="leading-tight">My Profile</span>
                        </button>
                    </li>
                    <li role="presentation">
                        <button class="w-full py-3.5 sm:py-4 px-1.5 sm:px-4 transition-all duration-200 flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 border-b-2 cursor-pointer focus:outline-none {{ request()->get('tab') == 'security' ? 'border-[#a28e46] text-[#a28e46] bg-white font-bold shadow-xs' : 'border-transparent text-stone-500 hover:text-[#a28e46] hover:bg-stone-100/50 font-semibold' }}"
                                id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="{{ request()->get('tab') == 'security' ? 'true' : 'false' }}">
                            <i class="fa-solid fa-shield-halved text-xs"></i>
                            <span class="leading-tight">Security</span>
                        </button>
                    </li>
                    <li role="presentation">
                        <button class="w-full py-3.5 sm:py-4 px-1.5 sm:px-4 transition-all duration-200 flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 border-b-2 cursor-pointer focus:outline-none {{ request()->get('tab') == 'orders' ? 'border-[#a28e46] text-[#a28e46] bg-white font-bold shadow-xs' : 'border-transparent text-stone-500 hover:text-[#a28e46] hover:bg-stone-100/50 font-semibold' }}"
                                id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="{{ request()->get('tab') == 'orders' ? 'true' : 'false' }}">
                            <div class="flex items-center gap-1.5">
                                <i class="fa-solid fa-bag-shopping text-xs"></i>
                                <span class="leading-tight">My Orders</span>
                            </div>
                            <span class="px-1.5 py-0.2 rounded-full text-[9px] sm:text-[10px] font-sans {{ request()->get('tab') == 'orders' ? 'bg-[#a28e46] text-white' : 'bg-stone-200 text-stone-700' }}">
                                {{ $allOrders->count() }}
                            </span>
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content Panes -->
            <div class="p-4 sm:p-8 lg:p-10">
                <div class="tab-content" id="profileTabContent">

                    <!-- ───────────────────────────────────────────────
                         TAB 1: MY PROFILE
                    ─────────────────────────────────────────────── -->
                    <div class="tab-pane fade {{ request()->get('tab') == 'profile' || !request()->has('tab') ? 'show active' : '' }}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-start">
                                
                                <!-- Personal Information Column -->
                                <div class="bg-stone-50/70 border border-stone-200/90 rounded-sm p-4 sm:p-7 shadow-xs">
                                    <div class="flex items-center gap-3 pb-3.5 sm:pb-4 mb-4 sm:mb-5 border-b border-stone-200/80">
                                        <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#faf7f0] border border-[#a28e46]/30 text-[#a28e46] flex items-center justify-center text-xs sm:text-sm shadow-xs flex-shrink-0">
                                            <i class="fa-solid fa-id-card"></i>
                                        </div>
                                        <div>
                                            <h2 class="font-serif font-bold text-xs sm:text-sm uppercase tracking-wider text-stone-900 leading-tight">
                                                Personal Information
                                            </h2>
                                            <p class="text-[10px] sm:text-[11px] text-stone-500">Manage your name and primary contact info</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3.5 sm:space-y-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                                            <div>
                                                <label for="firstName" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1">
                                                    First Name <span class="text-rose-500">*</span>
                                                </label>
                                                <input type="text" id="firstName" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" required
                                                       class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-white border border-stone-300 rounded-sm focus:border-[#a28e46] focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-colors">
                                            </div>
                                            <div>
                                                <label for="lastName" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1">
                                                    Last Name <span class="text-rose-500">*</span>
                                                </label>
                                                <input type="text" id="lastName" name="last_name" value="{{ old('last_name', auth()->user()->last_name) }}" required
                                                       class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-white border border-stone-300 rounded-sm focus:border-[#a28e46] focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-colors">
                                            </div>
                                        </div>

                                        <div>
                                            <label for="email" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1">
                                                Email Address <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                                   class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-white border border-stone-300 rounded-sm focus:border-[#a28e46] focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-colors">
                                            <span class="text-[10px] sm:text-[11px] text-stone-400 mt-1 block">Used for order receipts and account verification.</span>
                                        </div>

                                        <div>
                                            <label for="phone" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1">
                                                Phone Number
                                            </label>
                                            <input type="tel" id="phone" name="phone" value="{{ old('phone', optional(auth()->user()->customer)->phone) }}" placeholder="+880 1700-000000"
                                                   class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-white border border-stone-300 rounded-sm focus:border-[#a28e46] focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-colors">
                                            <span class="text-[10px] sm:text-[11px] text-stone-400 mt-1 block">For delivery coordination and order updates.</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address Information Column -->
                                <div class="bg-stone-50/70 border border-stone-200/90 rounded-sm p-4 sm:p-7 shadow-xs">
                                    <div class="flex items-center gap-3 pb-3.5 sm:pb-4 mb-4 sm:mb-5 border-b border-stone-200/80">
                                        <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#faf7f0] border border-[#a28e46]/30 text-[#a28e46] flex items-center justify-center text-xs sm:text-sm shadow-xs flex-shrink-0">
                                            <i class="fa-solid fa-location-dot"></i>
                                        </div>
                                        <div>
                                            <h2 class="font-serif font-bold text-xs sm:text-sm uppercase tracking-wider text-stone-900 leading-tight">
                                                Address Information
                                            </h2>
                                            <p class="text-[10px] sm:text-[11px] text-stone-500">Default shipping & delivery destination</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3.5 sm:space-y-4">
                                        <div>
                                            <label for="street" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1">
                                                Street Address
                                            </label>
                                            <input type="text" id="street" name="address_1" value="{{ old('address_1', optional(auth()->user()->customer)->address_1) }}" placeholder="House #, Road #, Area"
                                                   class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-white border border-stone-300 rounded-sm focus:border-[#a28e46] focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-colors">
                                        </div>

                                        <div>
                                            <label for="address_2" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1">
                                                Address Line 2 <span class="text-stone-400 font-normal">(Optional)</span>
                                            </label>
                                            <input type="text" id="address_2" name="address_2" value="{{ old('address_2', optional(auth()->user()->customer)->address_2) }}" placeholder="Apartment, suite, unit, floor, etc."
                                                   class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-white border border-stone-300 rounded-sm focus:border-[#a28e46] focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-colors">
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                                            <div>
                                                <label for="city" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1">
                                                    City
                                                </label>
                                                <input type="text" id="city" name="city" value="{{ old('city', optional(auth()->user()->customer)->city) }}" placeholder="e.g. Dhaka"
                                                       class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-white border border-stone-300 rounded-sm focus:border-[#a28e46] focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-colors">
                                            </div>
                                            <div>
                                                <label for="state" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1">
                                                    State / Division
                                                </label>
                                                <input type="text" id="state" name="state" value="{{ old('state', optional(auth()->user()->customer)->state) }}" placeholder="e.g. Dhaka Division"
                                                       class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-white border border-stone-300 rounded-sm focus:border-[#a28e46] focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-colors">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                                            <div>
                                                <label for="zip" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1">
                                                    ZIP / Postal Code
                                                </label>
                                                <input type="text" id="zip" name="zip_code" value="{{ old('zip_code', optional(auth()->user()->customer)->zip_code) }}" placeholder="e.g. 1212"
                                                       class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-white border border-stone-300 rounded-sm focus:border-[#a28e46] focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-colors">
                                            </div>
                                            <div>
                                                <label for="country" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1">
                                                    Country
                                                </label>
                                                <input type="text" id="country" name="country" value="{{ old('country', optional(auth()->user()->customer)->country ?? 'Bangladesh') }}" placeholder="e.g. Bangladesh"
                                                       class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-white border border-stone-300 rounded-sm focus:border-[#a28e46] focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-colors">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Save Button CTA -->
                            <div class="mt-6 sm:mt-8 pt-5 sm:pt-6 border-t border-stone-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <span class="text-[11px] sm:text-xs text-stone-400 font-light text-center sm:text-left order-2 sm:order-1">
                                    Changes will apply immediately across your upcoming checkout orders.
                                </span>
                                <button type="submit" class="w-full sm:w-auto bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest px-8 py-3.5 rounded-sm shadow-md hover:shadow-lg transition-all inline-flex items-center justify-center gap-2 cursor-pointer focus:outline-none order-1 sm:order-2">
                                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                                    <span>Save Profile Changes</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- ───────────────────────────────────────────────
                         TAB 2: SECURITY & PASSWORD
                    ─────────────────────────────────────────────── -->
                    <div class="tab-pane fade {{ request()->get('tab') == 'security' ? 'show active' : '' }}" id="security" role="tabpanel" aria-labelledby="security-tab">
                        <div class="max-w-2xl mx-auto">
                            <div class="bg-stone-50/70 border border-stone-200/90 rounded-sm p-4 sm:p-8 shadow-xs">
                                
                                <div class="flex items-center gap-3 pb-3.5 sm:pb-4 mb-5 sm:mb-6 border-b border-stone-200/80">
                                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#faf7f0] border border-[#a28e46]/30 text-[#a28e46] flex items-center justify-center text-xs sm:text-sm shadow-xs flex-shrink-0">
                                        <i class="fa-solid fa-lock"></i>
                                    </div>
                                    <div>
                                        <h2 class="font-serif font-bold text-xs sm:text-sm uppercase tracking-wider text-stone-900 leading-tight">
                                            Update Account Password
                                        </h2>
                                        <p class="text-[10px] sm:text-[11px] text-stone-500">Ensure your account uses a strong, unique password.</p>
                                    </div>
                                </div>

                                <form action="{{ route('password.update') }}" method="POST" class="space-y-3.5 sm:space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label for="currentPassword" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1">
                                            Current Password <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="password" id="currentPassword" name="current_password" required autocomplete="current-password"
                                               placeholder="••••••••"
                                               class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-white border border-stone-300 rounded-sm focus:border-[#a28e46] focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-colors">
                                        @if($errors->updatePassword->has('current_password'))
                                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $errors->updatePassword->first('current_password') }}</p>
                                        @endif
                                    </div>

                                    <div>
                                        <label for="newPassword" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1">
                                            New Password <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="password" id="newPassword" name="password" required autocomplete="new-password"
                                               placeholder="••••••••"
                                               class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-white border border-stone-300 rounded-sm focus:border-[#a28e46] focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-colors">
                                        @if($errors->updatePassword->has('password'))
                                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $errors->updatePassword->first('password') }}</p>
                                        @endif
                                    </div>

                                    <div>
                                        <label for="confirmPassword" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1">
                                            Confirm New Password <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="password" id="confirmPassword" name="password_confirmation" required autocomplete="new-password"
                                               placeholder="••••••••"
                                               class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-white border border-stone-300 rounded-sm focus:border-[#a28e46] focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-colors">
                                    </div>

                                    <div class="p-3 sm:p-3.5 bg-[#faf7f0] border border-[#a28e46]/20 rounded-sm text-[10px] sm:text-[11px] text-stone-600 space-y-1">
                                        <div class="font-bold text-[#8e7b39] uppercase tracking-wider flex items-center gap-1.5">
                                            <i class="fa-solid fa-circle-info text-[10px]"></i>
                                            <span>Password Guidelines</span>
                                        </div>
                                        <p class="text-stone-500 leading-relaxed">
                                            Must be at least 8 characters long and include uppercase and lowercase letters, numbers, and symbols.
                                        </p>
                                    </div>

                                    <div class="pt-3 sm:pt-4 text-center sm:text-right">
                                        <button type="submit" class="w-full sm:w-auto bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest px-8 py-3.5 rounded-sm shadow-md hover:shadow-lg transition-all inline-flex items-center justify-center gap-2 cursor-pointer focus:outline-none">
                                            <i class="fa-solid fa-key text-xs"></i>
                                            <span>Update Password</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- ───────────────────────────────────────────────
                         TAB 3: MY ORDERS
                    ─────────────────────────────────────────────── -->
                    <div class="tab-pane fade {{ request()->get('tab') == 'orders' ? 'show active' : '' }}" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                        
                        <!-- Top Filter Bar -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-5 border-b border-stone-200">
                            <div>
                                <h2 class="font-serif font-bold text-sm sm:text-base uppercase tracking-wider text-stone-900 leading-tight">
                                    Order History
                                </h2>
                                <p class="text-[11px] sm:text-xs text-stone-500">Track and review all your luxury beauty purchases</p>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto">
                                <label for="orderStatusFilter" class="text-[11px] font-bold text-stone-700 uppercase tracking-wider">
                                    Filter:
                                </label>
                                <div class="relative flex-1 sm:flex-none">
                                    <select name="status" id="orderStatusFilter"
                                            class="w-full sm:w-auto text-xs bg-stone-50 border border-stone-300 rounded-sm px-3 py-2 pr-8 font-medium text-stone-700 focus:border-[#a28e46] focus:bg-white focus:outline-none transition-colors cursor-pointer appearance-none">
                                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Orders ({{ $allOrders->count() }})</option>
                                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered ({{ $allOrders->where('status', 'delivered')->count() }})</option>
                                        <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Shipping ({{ $allOrders->where('status', 'shipping')->count() }})</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved ({{ $allOrders->where('status', 'approved')->count() }})</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending ({{ $allOrders->where('status', 'pending')->count() }})</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled ({{ $allOrders->where('status', 'cancelled')->count() }})</option>
                                    </select>
                                    <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 text-[10px] pointer-events-none"></i>
                                </div>
                                <div id="filterLoading" class="hidden">
                                    <i class="fas fa-spinner fa-spin text-[#a28e46] text-sm"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Orders List Container -->
                        <div id="ordersContainer">
                            @include('ecommerce.partials.orders-list', ['orders' => $orders, 'allOrders' => $allOrders])
                        </div>

                        <!-- Pagination Container -->
                        <div id="ordersPagination" class="mt-6 sm:mt-8">
                            @if($orders->count() > 0)
                                <div class="flex justify-center overflow-x-auto py-2">
                                    {{ $orders->appends(['tab' => 'orders', 'status' => request('status')])->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ───────────────────────────────────────────────
     MODALS
─────────────────────────────────────────────── -->

<!-- Cancel Confirmation Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mx-4 sm:mx-auto">
        <div class="modal-content rounded-sm border border-stone-300 shadow-xl overflow-hidden">
            <div class="modal-header bg-[#faf8f5] border-b border-stone-200 px-5 sm:px-6 py-3.5 sm:py-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-xs flex-shrink-0">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h5 class="modal-title font-serif font-bold text-xs sm:text-sm uppercase tracking-wider text-stone-900" id="cancelOrderModalLabel">
                        Cancel Order Confirmation
                    </h5>
                </div>
                <button type="button" class="btn-close text-xs" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-5 sm:px-6 py-4 sm:py-5 text-xs text-stone-600 space-y-2">
                <p class="font-medium text-stone-800">Are you sure you want to cancel this order?</p>
                <p class="text-stone-500">This action cannot be undone. If you have already made payment, our concierge team will initiate a refund according to our policy.</p>
            </div>
            <div class="modal-footer bg-stone-50 border-t border-stone-200 px-5 sm:px-6 py-3 flex flex-col sm:flex-row justify-end gap-2">
                <button type="button" class="w-full sm:w-auto px-4 py-2 border border-stone-300 hover:bg-stone-100 text-stone-700 text-xs font-bold uppercase tracking-wider rounded-sm transition-colors" data-bs-dismiss="modal">
                    Keep Order
                </button>
                <button type="button" class="w-full sm:w-auto px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold uppercase tracking-wider rounded-sm shadow-xs transition-colors" id="confirmCancelOrderBtn">
                    Yes, Cancel Order
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mx-4 sm:mx-auto">
        <div class="modal-content rounded-sm border border-stone-300 shadow-xl overflow-hidden">
            <div class="modal-header bg-rose-50/50 border-b border-stone-200 px-5 sm:px-6 py-3.5 sm:py-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-xs flex-shrink-0">
                        <i class="fa-solid fa-trash-can"></i>
                    </div>
                    <h5 class="modal-title font-serif font-bold text-xs sm:text-sm uppercase tracking-wider text-rose-900" id="deleteOrderModalLabel">
                        Delete Order Record
                    </h5>
                </div>
                <button type="button" class="btn-close text-xs" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-5 sm:px-6 py-5 sm:py-6 text-center text-xs text-stone-600 space-y-2">
                <p class="text-xs sm:text-sm font-medium text-stone-800">
                    Are you sure you want to delete order <strong id="deleteOrderNumber" class="text-stone-900 font-mono"></strong>?
                </p>
                <p class="text-stone-500">
                    This will permanently remove the cancelled order from your account history.
                </p>
            </div>
            <div class="modal-footer bg-stone-50 border-t border-stone-200 px-5 sm:px-6 py-3 flex flex-col sm:flex-row justify-end gap-2">
                <button type="button" class="w-full sm:w-auto px-4 py-2 border border-stone-300 hover:bg-stone-100 text-stone-700 text-xs font-bold uppercase tracking-wider rounded-sm transition-colors" data-bs-dismiss="modal">
                    No, Keep Record
                </button>
                <button type="button" class="w-full sm:w-auto px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold uppercase tracking-wider rounded-sm shadow-xs transition-colors" id="confirmDeleteOrderBtn">
                    Yes, Delete Order
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let formToSubmit = null;
        
        // Function to activate tab cleanly
        function activateTab(tabId) {
            document.querySelectorAll('#profileTabs button').forEach(function(tab) {
                tab.classList.remove('border-[#a28e46]', 'text-[#a28e46]', 'bg-white', 'font-bold', 'active', 'shadow-xs');
                tab.classList.add('border-transparent', 'text-stone-500', 'hover:text-[#a28e46]', 'hover:bg-stone-100/50', 'font-semibold');
                tab.setAttribute('aria-selected', 'false');
            });
            
            document.querySelectorAll('.tab-pane').forEach(function(pane) {
                pane.classList.remove('show', 'active');
            });
            
            const targetTab = document.getElementById(tabId + '-tab');
            const targetPane = document.getElementById(tabId);
            
            if (targetTab && targetPane) {
                targetTab.classList.remove('border-transparent', 'text-stone-500', 'hover:bg-stone-100/50');
                targetTab.classList.add('border-[#a28e46]', 'text-[#a28e46]', 'bg-white', 'font-bold', 'active', 'shadow-xs');
                targetTab.setAttribute('aria-selected', 'true');
                targetPane.classList.add('show', 'active');
            }
        }
        
        // Handle tab parameter from URL on load
        setTimeout(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab');
            if (activeTab) {
                activateTab(activeTab);
            }
        }, 50);
        
        // Handle tab clicks to update URL & styling
        document.querySelectorAll('#profileTabs button').forEach(function(tab) {
            tab.addEventListener('click', function(e) {
                const tabTarget = this.getAttribute('data-bs-target') || '';
                const tabId = tabTarget.replace('#', '');
                
                activateTab(tabId);
                
                const url = new URL(window.location);
                url.searchParams.set('tab', tabId);
                window.history.pushState({}, '', url);
            });
        });
        
        // Order Filter with AJAX
        const orderStatusFilter = document.getElementById('orderStatusFilter');
        const filterLoading = document.getElementById('filterLoading');
        const ordersContainer = document.getElementById('ordersContainer');
        const ordersPagination = document.getElementById('ordersPagination');
        
        if (orderStatusFilter) {
            orderStatusFilter.addEventListener('change', function() {
                const status = this.value;
                
                if (filterLoading) filterLoading.classList.remove('hidden');
                orderStatusFilter.disabled = true;
                
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '{{ csrf_token() }}';

                fetch('{{ route("profile.filter.orders") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (ordersContainer) ordersContainer.innerHTML = data.html;
                    if (ordersPagination) ordersPagination.innerHTML = data.pagination;
                    
                    const url = new URL(window.location);
                    if (status === 'all') {
                        url.searchParams.delete('status');
                    } else {
                        url.searchParams.set('status', status);
                    }
                    window.history.pushState({}, '', url);
                    
                    initializeOrderButtons();
                })
                .catch(error => {
                    console.error('Error filtering orders:', error);
                    window.location.href = '{{ route("profile.edit") }}?tab=orders&status=' + status;
                })
                .finally(() => {
                    if (filterLoading) filterLoading.classList.add('hidden');
                    orderStatusFilter.disabled = false;
                });
            });
        }
        
        // Function to bind cancel & delete modal triggers
        function initializeOrderButtons() {
            // Cancel Order Buttons
            const cancelButtons = document.querySelectorAll('.btn-cancel-order');
            cancelButtons.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    formToSubmit = this.closest('form') || document.querySelector(`form[action*="cancel-order/${this.dataset.orderId}"]`);
                });
            });
            
            // Delete Order Buttons
            const deleteButtons = document.querySelectorAll('.btn-delete-order');
            deleteButtons.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    formToSubmit = this.closest('form') || document.querySelector(`form[action*="delete-order/${this.dataset.orderId}"]`);
                    const orderNumber = this.getAttribute('data-order-number');
                    const deleteOrderNumberEl = document.getElementById('deleteOrderNumber');
                    if (deleteOrderNumberEl) {
                        deleteOrderNumberEl.textContent = orderNumber || '';
                    }
                });
            });
        }
        
        const confirmCancelBtn = document.getElementById('confirmCancelOrderBtn');
        if (confirmCancelBtn) {
            confirmCancelBtn.addEventListener('click', function() {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
            });
        }

        const confirmDeleteBtn = document.getElementById('confirmDeleteOrderBtn');
        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', function() {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
            });
        }

        // Initialize on page load
        initializeOrderButtons();
    });
</script>
@endpush