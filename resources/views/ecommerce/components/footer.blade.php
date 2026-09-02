<!-- Harosa Luxury Footer (100% Tailwind CSS matching design) -->
<footer class="bg-white pt-12 md:pt-16 pb-8 border-t border-stone-200/70 text-stone-600 font-sans">
    <div class="container mx-auto px-4 max-w-7xl">
        
        <!-- Main 4-Column Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">
            
            <!-- Column 1: CONTACT INFOR -->
            <div class="space-y-4">
                <h3 class="font-serif font-bold text-sm md:text-base text-gray-900 uppercase tracking-widest pb-1 border-b border-transparent">
                    CONTACT INFOR
                </h3>
                
                <div class="space-y-3 text-xs leading-relaxed text-stone-600">
                    <!-- Address -->
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot text-[#a28e46] mt-0.5 text-sm flex-shrink-0"></i>
                        <span>{{ $general_settings->contact_address ?? '123 Main Street, Anytown, CA 12345 - USA.' }}</span>
                    </div>

                    <!-- Phone -->
                    @if($general_settings->contact_phone)
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-phone text-[#a28e46] text-xs flex-shrink-0"></i>
                        <a href="tel:{{ $general_settings->contact_phone }}" class="text-stone-600 hover:text-[#a28e46] transition-colors no-underline">
                            {{ $general_settings->contact_phone }}
                        </a>
                    </div>
                    @endif

                    <!-- Email -->
                    @if($general_settings->contact_email)
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-[#a28e46] text-xs flex-shrink-0"></i>
                        <a href="mailto:{{ $general_settings->contact_email }}" class="text-stone-600 hover:text-[#a28e46] transition-colors no-underline">
                            {{ $general_settings->contact_email }}
                        </a>
                    </div>
                    @endif

                    <!-- Working Time -->
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-clock text-[#a28e46] text-xs flex-shrink-0"></i>
                        <span>Working time: 9.00 - 21.00</span>
                    </div>
                </div>

                <!-- Social Icons -->
                <div class="flex items-center gap-3.5 pt-2 text-stone-500 text-sm">
                    @if($general_settings->facebook_url)
                        <a href="{{ str_starts_with($general_settings->facebook_url, 'http') ? $general_settings->facebook_url : 'https://' . $general_settings->facebook_url }}" target="_blank" class="hover:text-[#a28e46] transition-transform hover:scale-110 no-underline" aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    @else
                        <a href="#" class="hover:text-[#a28e46] transition-transform hover:scale-110 no-underline"><i class="fa-brands fa-facebook-f"></i></a>
                    @endif

                    @if($general_settings->x_url)
                        <a href="{{ str_starts_with($general_settings->x_url, 'http') ? $general_settings->x_url : 'https://' . $general_settings->x_url }}" target="_blank" class="hover:text-[#a28e46] transition-transform hover:scale-110 no-underline" aria-label="Twitter">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    @else
                        <a href="#" class="hover:text-[#a28e46] transition-transform hover:scale-110 no-underline"><i class="fa-brands fa-twitter"></i></a>
                    @endif

                    @if($general_settings->youtube_url)
                        <a href="{{ str_starts_with($general_settings->youtube_url, 'http') ? $general_settings->youtube_url : 'https://' . $general_settings->youtube_url }}" target="_blank" class="hover:text-[#a28e46] transition-transform hover:scale-110 no-underline" aria-label="YouTube">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    @else
                        <a href="#" class="hover:text-[#a28e46] transition-transform hover:scale-110 no-underline"><i class="fa-brands fa-youtube"></i></a>
                    @endif

                    @if($general_settings->instagram_url)
                        <a href="{{ str_starts_with($general_settings->instagram_url, 'http') ? $general_settings->instagram_url : 'https://' . $general_settings->instagram_url }}" target="_blank" class="hover:text-[#a28e46] transition-transform hover:scale-110 no-underline" aria-label="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @else
                        <a href="#" class="hover:text-[#a28e46] transition-transform hover:scale-110 no-underline"><i class="fa-brands fa-instagram"></i></a>
                    @endif

                    @if($general_settings->whatsapp_url)
                        <a href="{{ str_starts_with($general_settings->whatsapp_url, 'http') ? $general_settings->whatsapp_url : 'https://' . $general_settings->whatsapp_url }}" target="_blank" class="hover:text-[#a28e46] transition-transform hover:scale-110 no-underline" aria-label="WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Column 2: PRODUCTS -->
            <div class="space-y-4">
                <h3 class="font-serif font-bold text-sm md:text-base text-gray-900 uppercase tracking-widest pb-1">
                    PRODUCTS
                </h3>
                <ul class="space-y-2.5 text-xs text-stone-600 list-none p-0 m-0">
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400 flex-shrink-0"></span>
                        <a href="{{ route('best.deal') }}" class="hover:text-[#a28e46] transition-colors no-underline">Prices drop</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400 flex-shrink-0"></span>
                        <a href="{{ route('product.archive') }}?sort=newest" class="hover:text-[#a28e46] transition-colors no-underline">New products</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400 flex-shrink-0"></span>
                        <a href="{{ route('product.archive') }}?sort=popular" class="hover:text-[#a28e46] transition-colors no-underline">Best sales</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400 flex-shrink-0"></span>
                        <a href="{{ route('product.archive') }}" class="hover:text-[#a28e46] transition-colors no-underline">Stores</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400 flex-shrink-0"></span>
                        <a href="{{ route('login') }}" class="hover:text-[#a28e46] transition-colors no-underline">Login</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400 flex-shrink-0"></span>
                        <a href="{{ route('profile.edit') }}" class="hover:text-[#a28e46] transition-colors no-underline">My account</a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: OUR COMPANY -->
            <div class="space-y-4">
                <h3 class="font-serif font-bold text-sm md:text-base text-gray-900 uppercase tracking-widest pb-1">
                    OUR COMPANY
                </h3>
                <ul class="space-y-2.5 text-xs text-stone-600 list-none p-0 m-0">
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400 flex-shrink-0"></span>
                        <a href="{{ route('about') }}" class="hover:text-[#a28e46] transition-colors no-underline">About us</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400 flex-shrink-0"></span>
                        <a href="{{ route('contact') }}" class="hover:text-[#a28e46] transition-colors no-underline">Contact us</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400 flex-shrink-0"></span>
                        <a href="{{ route('product.archive') }}" class="hover:text-[#a28e46] transition-colors no-underline">Delivery</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400 flex-shrink-0"></span>
                        <a href="{{ route('checkout') }}" class="hover:text-[#a28e46] transition-colors no-underline">Secure payment</a>
                    </li>
                    @foreach($additional_pages as $page)
                        @if($page->positioned_at == 'footer')
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-stone-400 flex-shrink-0"></span>
                            <a href="{{ route('additionalPage.show', $page->slug) }}" class="hover:text-[#a28e46] transition-colors no-underline">{{ $page->title }}</a>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <!-- Column 4: INSTAGRAM GALLERY -->
            <div class="space-y-4">
                <h3 class="font-serif font-bold text-sm md:text-base text-gray-900 uppercase tracking-widest pb-1">
                    INSTAGRAM
                </h3>
                <div class="grid grid-cols-3 gap-2 max-w-[240px]">
                    <a href="https://instagram.com" target="_blank" class="block aspect-square overflow-hidden rounded-sm group relative bg-stone-100 shadow-sm" aria-label="Instagram photo 1">
                        <img src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=200&auto=format&fit=crop&q=80" alt="Cosmetics" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-[#a28e46]/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-white text-xs">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="block aspect-square overflow-hidden rounded-sm group relative bg-stone-100 shadow-sm" aria-label="Instagram photo 2">
                        <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=200&auto=format&fit=crop&q=80" alt="Beauty Cream" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-[#a28e46]/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-white text-xs">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="block aspect-square overflow-hidden rounded-sm group relative bg-stone-100 shadow-sm" aria-label="Instagram photo 3">
                        <img src="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=200&auto=format&fit=crop&q=80" alt="Fragrance" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-[#a28e46]/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-white text-xs">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="block aspect-square overflow-hidden rounded-sm group relative bg-stone-100 shadow-sm" aria-label="Instagram photo 4">
                        <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=200&auto=format&fit=crop&q=80" alt="Skincare Spa" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-[#a28e46]/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-white text-xs">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="block aspect-square overflow-hidden rounded-sm group relative bg-stone-100 shadow-sm" aria-label="Instagram photo 5">
                        <img src="https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=200&auto=format&fit=crop&q=80" alt="Makeup" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-[#a28e46]/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-white text-xs">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="block aspect-square overflow-hidden rounded-sm group relative bg-stone-100 shadow-sm" aria-label="Instagram photo 6">
                        <img src="https://images.unsplash.com/photo-1526947425960-945c6e72858f?w=200&auto=format&fit=crop&q=80" alt="Organic Oils" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-[#a28e46]/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-white text-xs">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <!-- Bottom Copyright & Payment Badges -->
        <div class="mt-12 pt-6 border-t border-stone-200/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-stone-500">
            <p class="mb-0 text-center sm:text-left">
                &copy; {{ date('Y') }} {{ $general_settings->site_title ?? 'Harosa' }}. Made with <span class="text-rose-500">❤</span> by <a href="https://www.imbdagency.com/" target="_blank" class="text-stone-700 hover:text-[#a28e46] font-semibold transition-colors no-underline">IMBD Agency</a>
            </p>

            <!-- Payment Gateway Icons (Matching Screenshot) -->
            <div class="flex items-center gap-1.5 grayscale hover:grayscale-0 transition-all opacity-80 hover:opacity-100">
                <span class="px-2 py-1 bg-stone-100 rounded text-[10px] font-bold text-stone-600 uppercase border border-stone-200">PayPal</span>
                <span class="px-2 py-1 bg-stone-100 rounded text-[10px] font-bold text-stone-600 uppercase border border-stone-200">VISA</span>
                <span class="px-2 py-1 bg-stone-100 rounded text-[10px] font-bold text-stone-600 uppercase border border-stone-200">MasterCard</span>
                <span class="px-2 py-1 bg-stone-100 rounded text-[10px] font-bold text-stone-600 uppercase border border-stone-200">Discover</span>
                <span class="px-2 py-1 bg-stone-100 rounded text-[10px] font-bold text-stone-600 uppercase border border-stone-200">2CO</span>
            </div>
        </div>

    </div>
</footer>

<script>
    // Live Badge Updating
    window.updateCartQtyBadge = async function() {
        try {
            const res = await fetch("{{ route('cart.qtySum') }}");
            const data = await res.json();
            const qty = data.qty_sum || 0;
            document.querySelectorAll('.nav-cart-count, #cartBadge, #cartCountBadge').forEach(el => el.textContent = qty);
        } catch(e) {
            console.error('Failed to update cart badge:', e);
        }
    };

    window.updateWishlistCount = async function() {
        try {
            const res = await fetch('/wishlist/count');
            const data = await res.json();
            const count = (typeof data === 'object' && data !== null && 'count' in data) ? data.count : data;
            document.querySelectorAll('.nav-wishlist-count, #wishlistBadge').forEach(el => el.textContent = count);
        } catch(e) {
            console.error('Failed to update wishlist badge:', e);
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        if (typeof window.updateCartQtyBadge === 'function') window.updateCartQtyBadge();
        if (typeof window.updateWishlistCount === 'function') window.updateWishlistCount();
    });
</script>