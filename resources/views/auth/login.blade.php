@extends('layouts.guest')

@section('title', 'Sign In - Harosa Luxury Cosmetics')

@section('content')
<div class="w-full max-w-md">
    <!-- Luxury Login Card -->
    <div class="bg-white border border-stone-200/90 rounded-sm shadow-xl p-6 sm:p-10 relative overflow-hidden">
        
        <!-- Gold Accent Top Line -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#a28e46] via-[#d4af37] to-[#8e7b39]"></div>

        <!-- Header Content -->
        <div class="text-center mb-7">
            <div class="inline-flex items-center gap-1.5 bg-[#a28e46]/10 border border-[#a28e46]/30 text-[#8e7b39] px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full mb-3 shadow-2xs">
                <i class="fa-solid fa-crown text-[9px]"></i>
                <span>Client Sign In</span>
            </div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 uppercase tracking-tight mb-1.5">
                Welcome Back
            </h1>
            <p class="text-xs text-stone-500 font-light max-w-xs mx-auto">
                Sign in to manage your orders, wishlist, and client profile.
            </p>
        </div>

        <!-- Status Feedback -->
        @if (session('status'))
            <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-sm text-xs font-medium flex items-center gap-2.5">
                <i class="fa-solid fa-circle-check text-emerald-600 flex-shrink-0"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-sm text-xs font-medium flex items-center gap-2.5">
                <i class="fa-solid fa-circle-exclamation text-rose-600 flex-shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-4">
            @csrf

            <!-- Email or Username Input -->
            <div>
                <label for="email" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                    Email or Phone Number <span class="text-rose-500">*</span>
                </label>
                <div class="relative w-full">
                    <span class="input-icon-left">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           placeholder="Enter your email or phone"
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

            <!-- Password Input -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider">
                        Password <span class="text-rose-500">*</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[11px] font-semibold text-[#a28e46] hover:text-[#8e7b39] transition-colors no-underline">
                            Forgot password?
                        </a>
                    @endif
                </div>
                <div class="relative w-full">
                    <span class="input-icon-left">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           placeholder="••••••••"
                           style="padding-left: 40px !important; padding-right: 42px !important;"
                           class="w-full py-2.5 text-xs sm:text-sm bg-stone-50/70 border @error('password') border-rose-400 bg-rose-50/30 @else border-stone-300 @enderror rounded-sm focus:border-[#a28e46] focus:bg-white focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-all block">
                    <button type="button" id="togglePasswordBtn" class="input-icon-right" aria-label="Toggle password visibility">
                        <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs text-rose-600 mt-1.5 font-medium flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-exclamation text-[11px]"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Remember Me Option -->
            <div class="flex items-center pt-1">
                <label class="relative flex items-center gap-2 cursor-pointer select-none">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-stone-300 text-[#a28e46] focus:ring-[#a28e46]/30 cursor-pointer">
                    <span class="text-xs text-stone-600 font-normal">Remember me on this device</span>
                </label>
            </div>

            <!-- Submit Action Button -->
            <div class="pt-2">
                <button type="submit" id="loginBtn" class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest py-3.5 px-6 rounded-sm shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer focus:outline-none">
                    <span id="loginBtnText">Sign In</span>
                    <i class="fa-solid fa-arrow-right text-xs" id="loginBtnArrow"></i>
                    <div id="loginSpinner" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin hidden"></div>
                </button>
            </div>
        </form>

        <!-- Sign Up Footer Link -->
        @if (Route::has('register'))
            <div class="mt-8 pt-6 border-t border-stone-100 text-center">
                <p class="text-xs text-stone-500 font-light">
                    Don't have an account yet?
                    <a href="{{ route('register') }}" class="font-bold text-[#a28e46] hover:text-[#8e7b39] transition-colors ml-1 uppercase tracking-wider no-underline">
                        Register Here
                    </a>
                </p>
            </div>
        @endif

    </div>

    <!-- Guarantee / Security Badge -->
    <div class="mt-6 flex items-center justify-center gap-2 text-[11px] text-stone-400 font-light text-center">
        <i class="fa-solid fa-shield-halved text-[#a28e46] text-xs"></i>
        <span>256-bit SSL encrypted connection & security guarantee</span>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show/Hide Password Toggle
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');

        if (togglePasswordBtn && passwordInput && togglePasswordIcon) {
            togglePasswordBtn.addEventListener('click', function() {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                if (isPassword) {
                    togglePasswordIcon.classList.remove('fa-eye');
                    togglePasswordIcon.classList.add('fa-eye-slash');
                } else {
                    togglePasswordIcon.classList.remove('fa-eye-slash');
                    togglePasswordIcon.classList.add('fa-eye');
                }
            });
        }

        // Submit Button Loading State
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');
        const loginBtnText = document.getElementById('loginBtnText');
        const loginBtnArrow = document.getElementById('loginBtnArrow');
        const loginSpinner = document.getElementById('loginSpinner');

        if (loginForm && loginBtn) {
            loginForm.addEventListener('submit', function() {
                loginBtn.disabled = true;
                if (loginBtnText) loginBtnText.textContent = 'Signing in...';
                if (loginBtnArrow) loginBtnArrow.classList.add('hidden');
                if (loginSpinner) loginSpinner.classList.remove('hidden');
            });
        }
    });
</script>
@endpush