@extends('layouts.guest')

@section('title', 'Register - Harosa Luxury Cosmetics')

@section('content')
<div class="w-full max-w-lg">
    <!-- Luxury Register Card -->
    <div class="bg-white border border-stone-200/90 rounded-sm shadow-xl p-6 sm:p-10 relative overflow-hidden">
        
        <!-- Gold Accent Top Line -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#a28e46] via-[#d4af37] to-[#8e7b39]"></div>

        <!-- Header Content -->
        <div class="text-center mb-7">
            <div class="inline-flex items-center gap-1.5 bg-[#a28e46]/10 border border-[#a28e46]/30 text-[#8e7b39] px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full mb-3 shadow-2xs">
                <i class="fa-solid fa-crown text-[9px]"></i>
                <span>New Client Registration</span>
            </div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 uppercase tracking-tight mb-1.5">
                Create An Account
            </h1>
            <p class="text-xs text-stone-500 font-light max-w-xs mx-auto">
                Join Harosa to access personalized beauty recommendations and order tracking.
            </p>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-4">
            @csrf

            <!-- First & Last Name -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                <div>
                    <label for="first_name" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        First Name <span class="text-rose-500">*</span>
                    </label>
                    <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus autocomplete="given-name"
                           placeholder="First name"
                           class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-stone-50/70 border @error('first_name') border-rose-400 bg-rose-50/30 @else border-stone-300 @enderror rounded-sm focus:border-[#a28e46] focus:bg-white focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-all">
                    @error('first_name')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="last_name" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Last Name <span class="text-rose-500">*</span>
                    </label>
                    <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name"
                           placeholder="Last name"
                           class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-stone-50/70 border @error('last_name') border-rose-400 bg-rose-50/30 @else border-stone-300 @enderror rounded-sm focus:border-[#a28e46] focus:bg-white focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-all">
                    @error('last_name')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Email Input -->
            <div>
                <label for="email" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                    Email Address <span class="text-rose-500">*</span>
                </label>
                <div class="relative w-full">
                    <span class="input-icon-left">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                           placeholder="you@example.com"
                           style="padding-left: 40px !important; padding-right: 14px !important;"
                           class="w-full py-2.5 text-xs sm:text-sm bg-stone-50/70 border @error('email') border-rose-400 bg-rose-50/30 @else border-stone-300 @enderror rounded-sm focus:border-[#a28e46] focus:bg-white focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-all block">
                </div>
                @error('email')
                    <p class="text-xs text-rose-600 mt-1.5 font-medium flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-exclamation text-[11px]"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Password & Confirmation -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                <div>
                    <label for="password" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Password <span class="text-rose-500">*</span>
                    </label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           placeholder="••••••••"
                           class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-stone-50/70 border @error('password') border-rose-400 bg-rose-50/30 @else border-stone-300 @enderror rounded-sm focus:border-[#a28e46] focus:bg-white focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-all">
                    @error('password')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Confirm Password <span class="text-rose-500">*</span>
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           placeholder="••••••••"
                           class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-stone-50/70 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-all">
                </div>
            </div>

            <!-- Submit Action Button -->
            <div class="pt-3">
                <button type="submit" id="registerBtn" class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest py-3.5 px-6 rounded-sm shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer focus:outline-none">
                    <span id="registerBtnText">Complete Registration</span>
                    <i class="fa-solid fa-arrow-right text-xs" id="registerBtnArrow"></i>
                    <div id="registerSpinner" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin hidden"></div>
                </button>
            </div>
        </form>

        <!-- Sign In Footer Link -->
        <div class="mt-8 pt-6 border-t border-stone-100 text-center">
            <p class="text-xs text-stone-500 font-light">
                Already have an account?
                <a href="{{ route('login') }}" class="font-bold text-[#a28e46] hover:text-[#8e7b39] transition-colors ml-1 uppercase tracking-wider no-underline">
                    Sign In
                </a>
            </p>
        </div>

    </div>

    <!-- Guarantee / Security Badge -->
    <div class="mt-6 flex items-center justify-center gap-2 text-[11px] text-stone-400 font-light text-center">
        <i class="fa-solid fa-shield-halved text-[#a28e46] text-xs"></i>
        <span>Your personal information is always safe & protected</span>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const registerForm = document.getElementById('registerForm');
        const registerBtn = document.getElementById('registerBtn');
        const registerBtnText = document.getElementById('registerBtnText');
        const registerBtnArrow = document.getElementById('registerBtnArrow');
        const registerSpinner = document.getElementById('registerSpinner');

        if (registerForm && registerBtn) {
            registerForm.addEventListener('submit', function() {
                registerBtn.disabled = true;
                if (registerBtnText) registerBtnText.textContent = 'Creating account...';
                if (registerBtnArrow) registerBtnArrow.classList.add('hidden');
                if (registerSpinner) registerSpinner.classList.remove('hidden');
            });
        }
    });
</script>
@endpush
