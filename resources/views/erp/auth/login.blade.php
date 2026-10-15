<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Staff & Admin Portal | Harosa Luxury Cosmetics</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }
        .input-icon-left {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
            font-size: 13px;
            line-height: 1;
        }
        .input-icon-right {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
            background: transparent;
            border: none;
            padding: 0;
            cursor: pointer;
            font-size: 13px;
            line-height: 1;
        }
        .input-icon-right:hover {
            color: #4b5563;
        }
    </style>
</head>
<body class="bg-[#faf8f5] text-stone-800 min-h-screen flex flex-col justify-between antialiased selection:bg-[#a28e46]/20 selection:text-[#8e7b39]">

    <!-- Ambient Background Light Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-36 -right-36 w-[450px] h-[450px] bg-gradient-to-br from-[#a28e46]/15 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute -bottom-36 -left-36 w-[450px] h-[450px] bg-gradient-to-tr from-[#a28e46]/10 to-transparent rounded-full blur-3xl"></div>
    </div>

    <!-- Minimal Header -->
    <header class="relative z-10 w-full px-4 sm:px-8 py-4 sm:py-5 flex items-center justify-between border-b border-stone-200/60 bg-white/70 backdrop-blur-md">
        <a href="/" class="flex items-center gap-2.5 no-underline group">
            @if(isset($general_settings) && $general_settings->site_logo)
                <img src="{{ asset($general_settings->site_logo) }}" alt="Harosa" class="h-8 w-auto object-contain">
            @else
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#a28e46] to-[#6d5d28] text-white flex items-center justify-center font-serif font-bold text-sm shadow-xs group-hover:scale-105 transition-transform">
                    H
                </div>
                <span class="font-serif font-bold text-lg tracking-wider text-stone-900 group-hover:text-[#a28e46] transition-colors">
                    HAROSA
                </span>
            @endif
        </a>

        <div class="inline-flex items-center gap-1.5 bg-[#a28e46]/15 border border-[#a28e46]/30 text-[#8e7b39] px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full shadow-2xs">
            <i class="fa-solid fa-lock text-[9px]"></i>
            <span>ERP Portal</span>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="relative z-10 flex-1 flex items-center justify-center px-4 py-8 sm:py-12">
        <div class="w-full max-w-md">
            
            <!-- Luxury Admin Login Card -->
            <div class="bg-white border border-stone-200/90 rounded-sm shadow-xl p-6 sm:p-10 relative overflow-hidden">
                
                <!-- Gold Top Trim Line -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#a28e46] via-[#d4af37] to-[#8e7b39]"></div>

                <!-- Brand Section Header -->
                <div class="text-center mb-7">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[#a28e46] to-[#6d5d28] ring-2 ring-[#a28e46] ring-offset-2 ring-offset-white text-white flex items-center justify-center text-xl mx-auto mb-3.5 shadow-md">
                        <i class="fa-solid fa-crown text-base"></i>
                    </div>
                    <h1 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 uppercase tracking-tight mb-1">
                        Harosa Cosmetics
                    </h1>
                    <p class="text-xs text-stone-500 font-light">
                        Enterprise Resource Planning & Management Portal
                    </p>
                </div>

                <!-- Feedback Error Alert -->
                @if ($errors->any())
                    <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-sm text-xs font-medium flex items-center gap-2.5 shadow-xs">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-sm flex-shrink-0"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" id="erpLoginForm" class="space-y-4">
                    @csrf
                    <input type="hidden" name="login_source" value="erp">
                    
                    <!-- Identifier / Email -->
                    <div>
                        <label for="email" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                            Email or Phone Number <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative w-full">
                            <span class="input-icon-left">
                                <i class="fa-solid fa-user-circle"></i>
                            </span>
                            <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus
                                   placeholder="Enter employee identifier"
                                   style="padding-left: 40px !important; padding-right: 14px !important;"
                                   class="w-full py-2.5 text-xs sm:text-sm bg-stone-50/70 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-all block">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider">
                                Password <span class="text-rose-500">*</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[11px] font-semibold text-[#a28e46] hover:text-[#8e7b39] transition-colors no-underline">
                                    Forgot?
                                </a>
                            @endif
                        </div>
                        <div class="relative w-full">
                            <span class="input-icon-left">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input id="password" type="password" name="password" required
                                   placeholder="••••••••"
                                   style="padding-left: 40px !important; padding-right: 42px !important;"
                                   class="w-full py-2.5 text-xs sm:text-sm bg-stone-50/70 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:ring-1 focus:ring-[#a28e46]/30 focus:outline-none transition-all block">
                            <button type="button" id="togglePasswordBtn" class="input-icon-right" aria-label="Toggle password visibility">
                                <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me Option -->
                    <div class="flex items-center pt-1">
                        <label class="relative flex items-center gap-2 cursor-pointer select-none">
                            <input id="remember" type="checkbox" name="remember" class="w-4 h-4 rounded border-stone-300 text-[#a28e46] focus:ring-[#a28e46]/30 cursor-pointer">
                            <span class="text-xs text-stone-600 font-normal">Remember credentials</span>
                        </label>
                    </div>

                    <!-- Action Submit Button -->
                    <div class="pt-2">
                        <button type="submit" id="erpLoginBtn" class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest py-3.5 px-6 rounded-sm shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer focus:outline-none">
                            <span id="erpLoginBtnText">Sign In to Dashboard</span>
                            <i class="fa-solid fa-arrow-right text-xs" id="erpLoginBtnArrow"></i>
                            <div id="erpLoginSpinner" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin hidden"></div>
                        </button>
                    </div>
                </form>

            </div>

            <!-- Security Footnote -->
            <div class="mt-6 flex items-center justify-center gap-2 text-[11px] text-stone-400 font-light text-center">
                <i class="fa-solid fa-shield-halved text-[#a28e46] text-xs"></i>
                <span>Harosa ERP Enterprise Security & Role-Based Access</span>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 w-full py-4 text-center text-xs text-stone-400 border-t border-stone-200/60 bg-white/40">
        <p>&copy; {{ date('Y') }} Harosa Luxury Cosmetics. ERP Management Edition.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle
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

            // Button loading spinner
            const erpLoginForm = document.getElementById('erpLoginForm');
            const erpLoginBtn = document.getElementById('erpLoginBtn');
            const erpLoginBtnText = document.getElementById('erpLoginBtnText');
            const erpLoginBtnArrow = document.getElementById('erpLoginBtnArrow');
            const erpLoginSpinner = document.getElementById('erpLoginSpinner');

            if (erpLoginForm && erpLoginBtn) {
                erpLoginForm.addEventListener('submit', function() {
                    erpLoginBtn.disabled = true;
                    if (erpLoginBtnText) erpLoginBtnText.textContent = 'Authenticating...';
                    if (erpLoginBtnArrow) erpLoginBtnArrow.classList.add('hidden');
                    if (erpLoginSpinner) erpLoginSpinner.classList.remove('hidden');
                });
            }
        });
    </script>
</body>
</html>
