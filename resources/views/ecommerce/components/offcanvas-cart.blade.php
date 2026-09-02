<!-- Harosa Luxury Offcanvas Cart (100% Tailwind CSS & Pure Vanilla JS) -->
<div id="offcanvasCart" class="fixed inset-0 bg-black/60 backdrop-blur-[2px] z-[25000] opacity-0 pointer-events-none transition-opacity duration-300 flex justify-end">
    <div id="offcanvasCartPanel" class="w-full sm:w-[420px] max-w-full h-full bg-[#faf9f6] shadow-2xl flex flex-col transform translate-x-full transition-transform duration-300 ease-out z-[25001]">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#a28e46] to-[#8e7b39] text-white px-5 py-4 flex items-center justify-between shadow-sm flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h3 class="font-serif font-bold text-base tracking-wide uppercase mb-0">Shopping Bag</h3>
                <span id="cartCountBadge" class="bg-white/20 text-white text-[11px] font-bold px-2 py-0.5 rounded-full">0</span>
            </div>
            <button type="button" class="w-8 h-8 rounded-full bg-white/15 hover:bg-white/30 text-white flex items-center justify-center transition-colors cursor-pointer focus:outline-none" onclick="closeOffcanvasCart()">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Scrollable Body -->
        <div class="flex-grow overflow-y-auto p-4 sm:p-5">
            <!-- Items Container -->
            <div id="cartItems" class="space-y-3">
                <!-- Dynamically rendered items -->
            </div>

            <!-- Empty State -->
            <div id="emptyCart" class="hidden py-16 px-4 text-center flex flex-col items-center justify-center">
                <div class="w-20 h-20 rounded-full bg-stone-100 text-[#a28e46] flex items-center justify-center mb-4">
                    <svg class="w-9 h-9 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h4 class="font-serif font-bold text-base text-stone-800 uppercase tracking-wide mb-1">Your bag is empty</h4>
                <p class="text-xs text-stone-500 mb-6 max-w-xs">Explore our luxury cosmetics collection and find your favorite items!</p>
                <a href="{{ route('product.archive') }}" onclick="closeOffcanvasCart()" class="bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest px-7 py-3 rounded-full shadow-sm transition-colors no-underline">
                    START SHOPPING
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-white border-t border-stone-200/80 p-5 space-y-3.5 flex-shrink-0 shadow-[0_-4px_20px_rgba(0,0,0,0.03)]">
            <div class="flex items-center justify-between pb-3 border-b border-dashed border-stone-200">
                <span class="text-xs font-semibold uppercase tracking-wider text-stone-500">Subtotal</span>
                <span id="subtotalAmount" class="font-bold text-lg text-stone-900">৳ 0.00</span>
            </div>
            
            <a href="{{ route('checkout') }}" class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest py-3.5 px-4 rounded-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 no-underline text-center cursor-pointer">
                <i class="fa-solid fa-lock text-xs"></i>
                <span>PROCEED TO CHECKOUT</span>
            </a>

            <div class="flex items-center justify-between text-[11px] pt-1 text-stone-500">
                <a href="{{ route('product.archive') }}" onclick="closeOffcanvasCart()" class="font-semibold text-stone-600 hover:text-[#a28e46] uppercase tracking-wider no-underline transition-colors">
                    Continue Shopping <i class="fa-solid fa-arrow-right text-[8px] ml-0.5"></i>
                </a>
                <span class="text-emerald-600 font-medium flex items-center gap-1">
                    <i class="fa-solid fa-shield-halved"></i> Secure Checkout
                </span>
            </div>
        </div>

    </div>
</div>

<script>
    (function() {
        let __cartState = {};

        function renderCart(cartData) {
            const cartItemsDiv = document.getElementById('cartItems');
            const emptyCartDiv = document.getElementById('emptyCart');
            const subtotalAmount = document.getElementById('subtotalAmount');
            const cartCountBadge = document.getElementById('cartCountBadge');

            if (!cartItemsDiv || !emptyCartDiv) return;

            __cartState = {};
            const items = cartData && cartData.cart ? cartData.cart : [];

            if (items.length === 0) {
                cartItemsDiv.innerHTML = '';
                cartItemsDiv.classList.add('hidden');
                emptyCartDiv.classList.remove('hidden');
                if (subtotalAmount) subtotalAmount.textContent = '৳ 0.00';
                if (cartCountBadge) cartCountBadge.textContent = '0';
                return;
            }

            cartItemsDiv.classList.remove('hidden');
            emptyCartDiv.classList.add('hidden');

            let totalCount = 0;
            let html = '';

            items.forEach(item => {
                __cartState[item.cart_id] = {
                    qty: item.qty,
                    price: item.price,
                    max_stock: item.max_stock || 999
                };
                totalCount += item.qty;
                const atMax = item.qty >= (item.max_stock || 999);
                const imgUrl = item.image ? (item.image.startsWith('http') ? item.image : '/' + item.image) : '/static/default-product.jpg';
                const itemTotal = (item.price * item.qty).toLocaleString();

                html += `
                    <div class="cart-item bg-white border border-stone-200/80 rounded-sm p-3.5 shadow-sm flex items-start gap-3 relative transition-all" data-cart-id="${item.cart_id}" data-product-id="${item.product_id}" data-price="${item.price}" data-max-stock="${item.max_stock || 999}">
                        <img src="${imgUrl}" class="w-16 h-16 sm:w-18 sm:h-18 rounded-sm object-cover border border-stone-100 flex-shrink-0 bg-stone-50" alt="${item.name}" onerror="this.src='/static/default-product.jpg'">
                        
                        <div class="flex-grow min-w-0 pr-6">
                            <h4 class="font-serif text-xs sm:text-sm font-bold text-stone-900 uppercase tracking-wide truncate mb-1" title="${item.name}">${item.name}</h4>
                            
                            <div class="item-price-display font-bold text-xs sm:text-sm text-[#a28e46] mb-2.5">
                                ৳ ${itemTotal}
                            </div>

                            <div class="flex items-center gap-2">
                                <div class="inline-flex items-center border border-stone-300 rounded-sm overflow-hidden bg-stone-50">
                                    <button type="button" class="cart-qty-decrease w-6 h-6 flex items-center justify-center text-stone-600 hover:bg-stone-200 transition-colors focus:outline-none cursor-pointer" data-cart-id="${item.cart_id}" ${item.qty <= 1 ? 'disabled' : ''}>
                                        <i class="fa-solid fa-minus text-[9px]"></i>
                                    </button>
                                    <span class="quantity-display w-7 text-center text-xs font-bold text-stone-800">${item.qty}</span>
                                    <button type="button" class="cart-qty-increase w-6 h-6 flex items-center justify-center text-stone-600 hover:bg-stone-200 transition-colors focus:outline-none cursor-pointer" data-cart-id="${item.cart_id}" ${atMax ? 'disabled' : ''}>
                                        <i class="fa-solid fa-plus text-[9px]"></i>
                                    </button>
                                </div>
                                ${atMax ? '<span class="text-[10px] text-red-500 font-medium">Max stock</span>' : ''}
                            </div>
                        </div>

                        <button type="button" class="cart-item-remove absolute top-3 right-3 text-stone-400 hover:text-red-500 transition-colors focus:outline-none p-1 cursor-pointer" data-cart-id="${item.cart_id}" title="Remove item">
                            <i class="fa-solid fa-trash-can text-xs"></i>
                        </button>
                    </div>
                `;
            });

            cartItemsDiv.innerHTML = html;
            const totalFormatted = Number(cartData.cart_total || 0).toLocaleString();
            if (subtotalAmount) subtotalAmount.textContent = `৳ ${totalFormatted}`;
            if (cartCountBadge) cartCountBadge.textContent = totalCount;
        }

        function recalcSubtotal() {
            let total = 0;
            let count = 0;
            document.querySelectorAll('.cart-item').forEach(function(el) {
                const cartId = parseInt(el.getAttribute('data-cart-id'));
                const state = __cartState[cartId];
                if (state) {
                    total += state.price * state.qty;
                    count += state.qty;
                }
            });
            const subtotalAmount = document.getElementById('subtotalAmount');
            const cartCountBadge = document.getElementById('cartCountBadge');
            if (subtotalAmount) subtotalAmount.textContent = '৳ ' + total.toLocaleString();
            if (cartCountBadge) cartCountBadge.textContent = count;
            document.querySelectorAll('.nav-cart-count, #cartBadge').forEach(function(el){ el.textContent = count; });
        }

        // Increase Qty
        async function increaseQuantity(cartId) {
            const state = __cartState[cartId];
            if (!state || state.qty >= state.max_stock) return;

            state.qty += 1;
            const itemEl = document.querySelector(`.cart-item[data-cart-id="${cartId}"]`);
            if (itemEl) {
                itemEl.querySelector('.quantity-display').textContent = state.qty;
                itemEl.querySelector('.item-price-display').textContent = '৳ ' + (state.price * state.qty).toLocaleString();
                const decBtn = itemEl.querySelector('.cart-qty-decrease');
                const incBtn = itemEl.querySelector('.cart-qty-increase');
                if (decBtn) decBtn.disabled = state.qty <= 1;
                if (incBtn) incBtn.disabled = state.qty >= state.max_stock;
            }
            recalcSubtotal();
            if (typeof updateCartQtyBadge === 'function') updateCartQtyBadge();

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            try {
                await fetch('/cart/increase/' + cartId, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' }
                });
            } catch(e) {
                console.error(e);
            }
        }

        // Decrease Qty
        async function decreaseQuantity(cartId) {
            const state = __cartState[cartId];
            if (!state || state.qty <= 1) return;

            state.qty -= 1;
            const itemEl = document.querySelector(`.cart-item[data-cart-id="${cartId}"]`);
            if (itemEl) {
                itemEl.querySelector('.quantity-display').textContent = state.qty;
                itemEl.querySelector('.item-price-display').textContent = '৳ ' + (state.price * state.qty).toLocaleString();
                const decBtn = itemEl.querySelector('.cart-qty-decrease');
                const incBtn = itemEl.querySelector('.cart-qty-increase');
                if (decBtn) decBtn.disabled = state.qty <= 1;
                if (incBtn) incBtn.disabled = false;
            }
            recalcSubtotal();
            if (typeof updateCartQtyBadge === 'function') updateCartQtyBadge();

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            try {
                await fetch('/cart/decrease/' + cartId, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' }
                });
            } catch(e) {
                console.error(e);
            }
        }

        // Delete Item
        async function removeItem(cartId) {
            const itemEl = document.querySelector(`.cart-item[data-cart-id="${cartId}"]`);
            if (itemEl) {
                itemEl.style.opacity = '0.3';
                itemEl.style.pointerEvents = 'none';
            }
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            try {
                const res = await fetch('/cart/delete/' + cartId, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' }
                });
                const response = await res.json();
                if (response.success) {
                    delete __cartState[cartId];
                    if (itemEl) itemEl.remove();
                    recalcSubtotal();
                    if (typeof updateCartQtyBadge === 'function') updateCartQtyBadge();
                    if (Object.keys(__cartState).length === 0) {
                        const cartItemsDiv = document.getElementById('cartItems');
                        const emptyCartDiv = document.getElementById('emptyCart');
                        if (cartItemsDiv) cartItemsDiv.classList.add('hidden');
                        if (emptyCartDiv) emptyCartDiv.classList.remove('hidden');
                    }
                }
            } catch(e) {
                console.error(e);
            }
        }

        // Global Event delegation for cart actions
        document.addEventListener('click', function(e) {
            const incBtn = e.target.closest('.cart-qty-increase');
            const decBtn = e.target.closest('.cart-qty-decrease');
            const removeBtn = e.target.closest('.cart-item-remove');

            if (incBtn) {
                const cartId = parseInt(incBtn.getAttribute('data-cart-id'));
                increaseQuantity(cartId);
            } else if (decBtn) {
                const cartId = parseInt(decBtn.getAttribute('data-cart-id'));
                decreaseQuantity(cartId);
            } else if (removeBtn) {
                const cartId = parseInt(removeBtn.getAttribute('data-cart-id'));
                removeItem(cartId);
            }
        });

        window.fetchCartData = async function() {
            try {
                const res = await fetch('/cart/list?t=' + Date.now(), {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();
                renderCart(data);
            } catch(e) {
                console.error('Cart fetch error:', e);
            }
        };

        window.openOffcanvasCart = function() {
            const overlay = document.getElementById('offcanvasCart');
            const panel = document.getElementById('offcanvasCartPanel');
            if (!overlay || !panel) return;

            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100', 'pointer-events-auto');
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
            document.body.style.overflow = 'hidden';

            fetchCartData();
        };

        window.closeOffcanvasCart = function(e) {
            if (e && e.target && e.target.id !== 'offcanvasCart') return;
            const overlay = document.getElementById('offcanvasCart');
            const panel = document.getElementById('offcanvasCartPanel');
            if (!overlay || !panel) return;

            panel.classList.remove('translate-x-0');
            panel.classList.add('translate-x-full');
            overlay.classList.remove('opacity-100', 'pointer-events-auto');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = '';
        };

        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('offcanvasCart');
            if (overlay) {
                overlay.addEventListener('click', window.closeOffcanvasCart);
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') window.closeOffcanvasCart();
        });

    })();
</script>
