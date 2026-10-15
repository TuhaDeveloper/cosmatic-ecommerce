<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Harosa Luxury Cosmetics'))</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind / Assets -->
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
    @stack('styles')
</head>
<body class="bg-[#faf8f5] text-stone-800 min-h-screen flex flex-col justify-between antialiased selection:bg-[#a28e46]/20 selection:text-[#8e7b39]">

    <!-- Ambient Background Lighting -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-gradient-to-br from-[#a28e46]/12 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] bg-gradient-to-tr from-[#a28e46]/10 to-transparent rounded-full blur-3xl"></div>
    </div>

    <!-- Top Minimal Navigation -->
    <header class="relative z-10 w-full px-4 sm:px-8 py-5 flex items-center justify-between border-b border-stone-200/60 bg-white/70 backdrop-blur-md">
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

        <a href="/" class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-stone-500 hover:text-[#a28e46] transition-colors no-underline">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            <span class="hidden sm:inline">Back to Store</span>
            <span class="sm:hidden">Store</span>
        </a>
    </header>

    <!-- Main Content Section -->
    <main class="relative z-10 flex-1 flex items-center justify-center px-4 py-8 sm:py-14">
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>

    <!-- Simple Footer -->
    <footer class="relative z-10 w-full py-4 text-center text-xs text-stone-400 border-t border-stone-200/60 bg-white/40">
        <p>&copy; {{ date('Y') }} Harosa Luxury Cosmetics. All rights reserved.</p>
    </footer>

    @stack('scripts')
</body>
</html>
