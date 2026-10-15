@extends('layouts.guest')

@section('title', 'Set New Password - Harosa Luxury Cosmetics')

@section('content')
<div class="w-full max-w-md">
    <!-- Luxury Reset Password Card -->
    <div class="bg-white border border-stone-200/90 rounded-sm shadow-xl p-6 sm:p-10 relative overflow-hidden">
        
        <!-- Gold Accent Top Line -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#a28e46] via-[#d4af37] to-[#8e7b39]"></div>

        <!-- Header Content -->
        <div class="text-center mb-7">
            <div class="inline-flex items-center gap-1.5 bg-[#a28e46]/10 border border-[#a28e46]/30 text-[#8e7b39] px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full mb-3 shadow-2xs">
                <i class="fa-solid fa-lock text-[9px]"></i>
                <span>Password Update</span>
            </div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 uppercase tracking-tight mb-1.5">
                Set New Password
            </h1>
            <p class="text-xs text-stone-500 font-light max-w-xs mx-auto">
                Create a strong password to secure your Harosa client account.
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm" class="space-y-4">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                    Email Address <span class="text-rose-500">*</span>
                </label>
                <div class="relative w-full">
                    <span class="input-icon-left">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                           placeholder="you@example.com"
                           style="padding-left: 40px !important; padding-right: 14px !important;"
                           class="w-full py-2.5 text-xs sm:text-sm bg-stone-50/70 border @error('email') border-rose-400 bg-rose-50/30 @else border-stone-300 @enderror rounded-sm focus:border-[#a28e46] focus:bg-white focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-all block">
                </div>
                @error('email')
                    <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                    New Password <span class="text-rose-500">*</span>
                </label>
                <div class="relative w-full">
                    <span class="input-icon-left">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           placeholder="••••••••"
                           style="padding-left: 40px !important; padding-right: 42px !important;"
                           class="w-full py-2.5 text-xs sm:text-sm bg-stone-50/70 border @error('password') border-rose-400 bg-rose-50/30 @else border-stone-300 @enderror rounded-sm focus:border-[#a28e46] focus:bg-white focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-all block">
                    <button type="button" id="togglePasswordBtn" class="input-icon-right" aria-label="Toggle password visibility">
                        <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                    Confirm Password <span class="text-rose-500">*</span>
                </label>
                <div class="relative w-full">
                    <span class="input-icon-left">
                        <i class="fa-solid fa-shield-halved"></i>
                    </span>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           placeholder="••••••••"
                           style="padding-left: 40px !important; padding-right: 14px !important;"
                           class="w-full py-2.5 text-xs sm:text-sm bg-stone-50/70 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-all block">
                </div>
            </div>

            <!-- Submit Action Button -->
            <div class="pt-2">
                <button type="submit" id="resetPasswordBtn" class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest py-3.5 px-6 rounded-sm shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer focus:outline-none">
                    <span id="resetPasswordBtnText">Reset Password</span>
                    <i class="fa-solid fa-arrow-right text-xs" id="resetPasswordBtnArrow"></i>
                    <div id="resetPasswordSpinner" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin hidden"></div>
                </button>
            </div>
        </form>

        <!-- Back to Sign In Link -->
        <div class="mt-8 pt-6 border-t border-stone-100 text-center">
            <p class="text-xs text-stone-500 font-light">
                <a href="{{ route('login') }}" class="font-bold text-[#a28e46] hover:text-[#8e7b39] transition-colors uppercase tracking-wider no-underline">
                    Back to Sign In
                </a>
            </p>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Password
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

        // Submit loading
        const resetPasswordForm = document.getElementById('resetPasswordForm');
        const resetPasswordBtn = document.getElementById('resetPasswordBtn');
        const resetPasswordBtnText = document.getElementById('resetPasswordBtnText');
        const resetPasswordBtnArrow = document.getElementById('resetPasswordBtnArrow');
        const resetPasswordSpinner = document.getElementById('resetPasswordSpinner');

        if (resetPasswordForm && resetPasswordBtn) {
            resetPasswordForm.addEventListener('submit', function() {
                resetPasswordBtn.disabled = true;
                if (resetPasswordBtnText) resetPasswordBtnText.textContent = 'Updating password...';
                if (resetPasswordBtnArrow) resetPasswordBtnArrow.classList.add('hidden');
                if (resetPasswordSpinner) resetPasswordSpinner.classList.remove('hidden');
            });
        }
    });
</script>
@endpush
