@extends('layouts.guest')

@section('title', 'Reset Password - Harosa Luxury Cosmetics')

@section('content')
<div class="w-full max-w-md">
    <!-- Luxury Reset Card -->
    <div class="bg-white border border-stone-200/90 rounded-sm shadow-xl p-6 sm:p-10 relative overflow-hidden">
        
        <!-- Gold Accent Top Line -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#a28e46] via-[#d4af37] to-[#8e7b39]"></div>

        <!-- Header Content -->
        <div class="text-center mb-7">
            <div class="inline-flex items-center gap-1.5 bg-[#a28e46]/10 border border-[#a28e46]/30 text-[#8e7b39] px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full mb-3 shadow-2xs">
                <i class="fa-solid fa-key text-[9px]"></i>
                <span>Account Recovery</span>
            </div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 uppercase tracking-tight mb-1.5">
                Forgot Password
            </h1>
            <p class="text-xs text-stone-500 font-light max-w-xs mx-auto">
                Enter your account email to receive secure password reset instructions.
            </p>
        </div>

        <!-- Status Feedback -->
        @if (session('status'))
            <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-sm text-xs font-medium flex items-center gap-2.5">
                <i class="fa-solid fa-circle-check text-emerald-600 flex-shrink-0"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}" id="resetForm" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                    Email Address <span class="text-rose-500">*</span>
                </label>
                <div class="relative w-full">
                    <span class="input-icon-left">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
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

            <!-- Submit Action Button -->
            <div class="pt-2">
                <button type="submit" id="resetBtn" class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest py-3.5 px-6 rounded-sm shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer focus:outline-none">
                    <span id="resetBtnText">Email Password Reset Link</span>
                    <i class="fa-solid fa-paper-plane text-xs" id="resetBtnArrow"></i>
                    <div id="resetSpinner" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin hidden"></div>
                </button>
            </div>
        </form>

        <!-- Back to Sign In Link -->
        <div class="mt-8 pt-6 border-t border-stone-100 text-center">
            <p class="text-xs text-stone-500 font-light">
                Remember your credentials?
                <a href="{{ route('login') }}" class="font-bold text-[#a28e46] hover:text-[#8e7b39] transition-colors ml-1 uppercase tracking-wider no-underline">
                    Return to Sign In
                </a>
            </p>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const resetForm = document.getElementById('resetForm');
        const resetBtn = document.getElementById('resetBtn');
        const resetBtnText = document.getElementById('resetBtnText');
        const resetBtnArrow = document.getElementById('resetBtnArrow');
        const resetSpinner = document.getElementById('resetSpinner');

        if (resetForm && resetBtn) {
            resetForm.addEventListener('submit', function() {
                resetBtn.disabled = true;
                if (resetBtnText) resetBtnText.textContent = 'Sending email...';
                if (resetBtnArrow) resetBtnArrow.classList.add('hidden');
                if (resetSpinner) resetSpinner.classList.remove('hidden');
            });
        }
    });
</script>
@endpush
