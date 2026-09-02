import './bootstrap';

import Alpine from 'alpinejs';
import Splide from '@splidejs/splide';
import '@splidejs/splide/css';

window.Alpine = Alpine;
window.Splide = Splide;

Alpine.start();

// Delegated wishlist toggle handler
document.addEventListener('click', async (event) => {
    const button = event.target.closest('.wishlist-btn, .product-wishlist-top');
    if (!button) return;
    event.preventDefault();
    event.stopPropagation();

    const productId = button.getAttribute('data-product-id');
    if (!productId) return;

    const isAuth = document.querySelector('meta[name="auth-check"]')?.getAttribute('content') === '1';
    if (!isAuth) {
        if (typeof window.showToast === 'function') {
            window.showToast('Please login first to use your wishlist.', 'error');
        }
        return;
    }

    const icon = button.querySelector('i');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    if (button.dataset.loading === 'true') return;
    button.dataset.loading = 'true';
    button.setAttribute('disabled', 'disabled');

    try {
        const response = await fetch(`/add-remove-wishlist/${productId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
            },
            body: JSON.stringify({}),
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result?.message || `Wishlist update failed (${response.status})`);
        }

        const wasActive = button.classList.contains('active') || (icon && icon.classList.contains('fas'));
        const added = typeof result?.added !== 'undefined' ? !!result.added : !wasActive;

        if (icon) {
            if (added) {
                icon.classList.remove('far');
                icon.classList.add('fas', 'text-red-500', 'active');
                button.classList.add('active');
            } else {
                icon.classList.remove('fas', 'text-red-500', 'active');
                icon.classList.add('far');
                button.classList.remove('active');
            }
        }

        if (typeof window.showToast === 'function') {
            window.showToast(added ? 'Added to wishlist!' : 'Removed from wishlist!');
        }
        if (typeof window.updateWishlistCount === 'function') {
            window.updateWishlistCount();
        }
    } catch (err) {
        console.error('Wishlist error:', err);
        if (typeof window.showToast === 'function') {
            window.showToast('Could not update wishlist', 'error');
        }
    } finally {
        delete button.dataset.loading;
        button.removeAttribute('disabled');
    }
}, true);

// ── Quick Variation State ──
let currentQuickModalProduct = null;
let selectedQuickAttributes = {};
let selectedQuickVariation = null;

// Global quick add to cart handler
window.handleQuickAddToCart = async function(productId, hasVariations, productSlug) {
    if (hasVariations) {
        window.openQuickVariationModal(productId, productSlug);
    } else {
        // Direct add to cart for simple products
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        try {
            const response = await fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({}),
            });

            const result = await response.json();
            if (response.ok && result.success) {
                if (typeof window.showToast === 'function') {
                    window.showToast('Product added to cart!');
                }
                if (typeof window.updateCartQtyBadge === 'function') {
                    window.updateCartQtyBadge();
                }
                if (typeof window.openOffcanvasCart === 'function') {
                    window.openOffcanvasCart();
                }
            } else if (result.error_type === 'variation_required') {
                window.openQuickVariationModal(productId, productSlug);
            } else {
                if (typeof window.showToast === 'function') {
                    window.showToast(result.message || 'Failed to add product to cart', 'error');
                }
            }
        } catch (e) {
            console.error('Cart add error:', e);
            if (typeof window.showToast === 'function') {
                window.showToast('Failed to add product to cart', 'error');
            }
        }
    }
};

// Open Quick Variation Modal
window.openQuickVariationModal = async function(productId, productSlug) {
    const modal = document.getElementById('quickVariationModal');
    const loading = document.getElementById('quickModalLoading');
    const content = document.getElementById('quickModalContent');
    if (!modal) return;

    modal.classList.remove('opacity-0', 'pointer-events-none');
    modal.classList.add('opacity-100', 'pointer-events-auto');
    const panel = modal.querySelector('div');
    if (panel) {
        panel.classList.remove('translate-y-full', 'sm:scale-95');
        panel.classList.add('translate-y-0', 'sm:scale-100');
    }

    if (loading) loading.classList.remove('hidden');
    if (content) content.classList.add('hidden');

    try {
        const response = await fetch(`/api/products/${productId}/quick-variation`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        });
        const json = await response.json();
        if (!json.success || !json.data) {
            window.location.href = `/product/${productSlug}`;
            return;
        }

        currentQuickModalProduct = json.data;
        selectedQuickAttributes = {};
        selectedQuickVariation = null;

        // Reset Qty
        const qtyInput = document.getElementById('quickModalQty');
        if (qtyInput) qtyInput.value = '1';

        // Render Data
        document.getElementById('quickModalImg').src = currentQuickModalProduct.image;
        document.getElementById('quickModalCategory').textContent = currentQuickModalProduct.category;
        document.getElementById('quickModalTitle').textContent = currentQuickModalProduct.name;
        document.getElementById('quickModalViewDetails').href = `/product/${currentQuickModalProduct.slug}`;

        updateQuickModalPrice();

        // Render Attributes (Size, Volume, Color)
        const attrContainer = document.getElementById('quickModalAttributes');
        attrContainer.innerHTML = '';

        if (currentQuickModalProduct.attributes && currentQuickModalProduct.attributes.length > 0) {
            currentQuickModalProduct.attributes.forEach(attr => {
                const groupDiv = document.createElement('div');
                groupDiv.className = 'space-y-1.5';

                const label = document.createElement('span');
                label.className = 'text-xs font-semibold text-stone-700 uppercase tracking-wider block';
                label.textContent = `Select ${attr.name}:`;
                groupDiv.appendChild(label);

                const optionsDiv = document.createElement('div');
                optionsDiv.className = 'flex flex-wrap gap-2';

                attr.values.forEach((val, idx) => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = `quick-attr-btn px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider rounded border transition-all cursor-pointer focus:outline-none ${idx === 0 ? 'border-[#a28e46] bg-[#faf7f0] text-[#a28e46]' : 'border-stone-300 bg-white text-stone-700 hover:border-stone-400'}`;
                    btn.textContent = val.label;
                    btn.dataset.attrId = attr.id;
                    btn.dataset.valueId = val.id;

                    btn.addEventListener('click', function() {
                        optionsDiv.querySelectorAll('.quick-attr-btn').forEach(b => {
                            b.classList.remove('border-[#a28e46]', 'bg-[#faf7f0]', 'text-[#a28e46]');
                            b.classList.add('border-stone-300', 'bg-white', 'text-stone-700');
                        });
                        this.classList.remove('border-stone-300', 'bg-white', 'text-stone-700');
                        this.classList.add('border-[#a28e46]', 'bg-[#faf7f0]', 'text-[#a28e46]');

                        selectedQuickAttributes[attr.id] = val.id;
                        matchQuickVariation();
                    });

                    // Auto-select first option
                    if (idx === 0) {
                        selectedQuickAttributes[attr.id] = val.id;
                    }

                    optionsDiv.appendChild(btn);
                });

                groupDiv.appendChild(optionsDiv);
                attrContainer.appendChild(groupDiv);
            });
        }

        matchQuickVariation();

        if (loading) loading.classList.add('hidden');
        if (content) content.classList.remove('hidden');

    } catch (err) {
        console.error('Quick variation load error:', err);
        window.location.href = `/product/${productSlug}`;
    }
};

// Match selected combination to variation
function matchQuickVariation() {
    if (!currentQuickModalProduct || !currentQuickModalProduct.variations) return;

    selectedQuickVariation = currentQuickModalProduct.variations.find(v => {
        return Object.keys(selectedQuickAttributes).every(attrId => {
            return String(v.attribute_combinations[attrId]) === String(selectedQuickAttributes[attrId]);
        });
    });

    updateQuickModalPrice();

    const stockEl = document.getElementById('quickModalStockStatus');
    const addBtn = document.getElementById('quickModalAddToCartBtn');

    if (selectedQuickVariation) {
        if (selectedQuickVariation.image) {
            document.getElementById('quickModalImg').src = selectedQuickVariation.image;
        }
        if (selectedQuickVariation.in_stock) {
            stockEl.textContent = `In Stock (${selectedQuickVariation.stock} available)`;
            stockEl.className = 'text-[11px] text-emerald-600 font-medium';
            addBtn.disabled = false;
            addBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            stockEl.textContent = 'Out of Stock';
            stockEl.className = 'text-[11px] text-red-500 font-medium';
            addBtn.disabled = true;
            addBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    } else {
        stockEl.textContent = 'Please select options';
        stockEl.className = 'text-[11px] text-amber-600 font-medium';
    }
}

function updateQuickModalPrice() {
    if (!currentQuickModalProduct) return;
    const priceEl = document.getElementById('quickModalPrice');
    const origPriceEl = document.getElementById('quickModalOriginalPrice');

    const item = selectedQuickVariation || currentQuickModalProduct;
    const price = Number(item.price || 0);
    const effPrice = Number(item.effective_price || item.discount || price);

    priceEl.textContent = `৳ ${effPrice.toLocaleString()}`;
    if (price > effPrice) {
        origPriceEl.textContent = `৳ ${price.toLocaleString()}`;
        origPriceEl.classList.remove('hidden');
    } else {
        origPriceEl.classList.add('hidden');
    }
}

// Close Quick Modal
window.closeQuickVariationModal = function(e) {
    if (e && e.target && e.target.id !== 'quickVariationModal') return;
    const modal = document.getElementById('quickVariationModal');
    if (!modal) return;
    modal.classList.add('opacity-0', 'pointer-events-none');
    modal.classList.remove('opacity-100', 'pointer-events-auto');
    const panel = modal.querySelector('div');
    if (panel) {
        panel.classList.add('translate-y-full', 'sm:scale-95');
        panel.classList.remove('translate-y-0', 'sm:scale-100');
    }
};

// Change Quick Qty
window.changeQuickModalQty = function(delta) {
    const input = document.getElementById('quickModalQty');
    if (!input) return;
    let val = parseInt(input.value) || 1;
    val += delta;
    if (val < 1) val = 1;
    input.value = val;
};

// Submit Quick Add To Cart
window.submitQuickModalAddToCart = async function() {
    if (!currentQuickModalProduct) return;

    if (currentQuickModalProduct.has_variations && !selectedQuickVariation) {
        if (typeof window.showToast === 'function') {
            window.showToast('Please select variation options first.', 'error');
        }
        return;
    }

    const qty = parseInt(document.getElementById('quickModalQty')?.value) || 1;
    const addBtn = document.getElementById('quickModalAddToCartBtn');
    const origHtml = addBtn.innerHTML;

    addBtn.disabled = true;
    addBtn.innerHTML = '<div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div> Adding...';

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const payload = {
        qty: qty,
        variation_id: selectedQuickVariation ? selectedQuickVariation.id : null,
    };

    try {
        const response = await fetch(`/cart/add-page/${currentQuickModalProduct.id}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
            },
            body: JSON.stringify(payload),
        });

        const result = await response.json();

        if (response.ok && result.success) {
            closeQuickVariationModal();
            if (typeof window.showToast === 'function') {
                window.showToast('Product added to cart!');
            }
            if (typeof window.updateCartQtyBadge === 'function') {
                window.updateCartQtyBadge();
            }
            if (typeof window.openOffcanvasCart === 'function') {
                window.openOffcanvasCart();
            }
        } else {
            if (typeof window.showToast === 'function') {
                window.showToast(result.message || 'Failed to add product to cart', 'error');
            }
        }
    } catch (err) {
        console.error('Cart submit error:', err);
        if (typeof window.showToast === 'function') {
            window.showToast('Failed to add product to cart', 'error');
        }
    } finally {
        addBtn.disabled = false;
        addBtn.innerHTML = origHtml;
    }
};

// Render Reusable Harosa Product Card (Matching image with hover Add to Cart button)
function renderHarosaProductCard(product) {
    try {
        const price = Number(product.price || 0);
        const discount = Number(product.discount || 0);
        const finalPrice = discount > 0 ? discount : price;
        const discountPercent = discount > 0 && discount < price ? Math.round(((price - discount) / price) * 100) : 0;
        const image = product.image || '/static/default-product.jpg';
        const isWishlisted = product.is_wishlisted === true;
        const categoryName = product.category_name || (product.category ? (product.category.name || product.category) : 'Studio Design');
        const hasVariations = product.has_variations === true || product.has_variations === 1 || product.has_variations === '1';

        return `
        <li class="splide__slide">
            <div class="group relative bg-white border-0 overflow-hidden flex flex-col items-center text-center p-2 transition-all duration-300" data-href="/product/${product.slug}">
                <div class="relative w-full aspect-[4/5] overflow-hidden bg-stone-50 mb-2.5 group/img">
                    <!-- Black NEW Tag (top-left) -->
                    <span class="absolute top-0 left-0 bg-[#222222] text-white text-[10px] font-bold px-2.5 py-0.5 rounded-none uppercase tracking-wider z-10">NEW</span>
                    
                    <!-- Black Discount Tag (top-right) -->
                    ${discountPercent > 0 ? `<span class="absolute top-0 right-0 bg-[#222222] text-white text-[10px] font-bold px-2 py-0.5 rounded-none uppercase tracking-wider z-10">-${discountPercent}%</span>` : ''}
                    
                    <!-- Main Product Image -->
                    <a href="/product/${product.slug}" class="block w-full h-full">
                        <img src="${image}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 block" alt="${product.name}" loading="lazy" onerror="this.onerror=null; this.src='/static/default-product.jpg';">
                    </a>

                    <!-- Mobile Quick 1-Tap Add Button (Always visible on mobile/touch screens) -->
                    <button type="button" 
                            class="md:hidden absolute bottom-2 right-2 w-8 h-8 rounded-full bg-[#a28e46] active:bg-[#8e7b39] text-white shadow-md flex items-center justify-center text-xs z-20 cursor-pointer focus:outline-none transition-transform active:scale-95"
                            onclick="event.stopPropagation(); handleQuickAddToCart(${product.id}, ${hasVariations ? 'true' : 'false'}, '${product.slug}');"
                            aria-label="Add to cart">
                        <i class="fa-solid fa-bag-shopping text-[11px]"></i>
                    </button>

                    <!-- Desktop Hover Quick Add To Cart Button (Slides up on desktop hover) -->
                    <div class="hidden md:flex absolute inset-x-0 bottom-0 p-2.5 bg-gradient-to-t from-black/70 via-black/30 to-transparent translate-y-full group-hover/img:translate-y-0 transition-transform duration-300 items-center justify-center z-20">
                        <button type="button" 
                                class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-[11px] uppercase tracking-wider py-2 px-3 rounded-none shadow-md transition-all flex items-center justify-center gap-1.5 cursor-pointer focus:outline-none"
                                onclick="event.stopPropagation(); handleQuickAddToCart(${product.id}, ${hasVariations ? 'true' : 'false'}, '${product.slug}');">
                            <i class="fa-solid fa-cart-shopping text-[10px]"></i>
                            <span>ADD TO CART</span>
                        </button>
                    </div>
                </div>
                
                <div class="w-full flex flex-col items-center text-center">
                    <!-- Category with Tag Icon -->
                    <div class="text-[11px] text-gray-400 flex items-center justify-center gap-1 mb-1 font-medium">
                        <i class="fa-solid fa-tag text-[9px] text-gray-400"></i>
                        <span class="truncate max-w-[160px]">${categoryName}</span>
                    </div>
                    
                    <!-- Serif Title -->
                    <a href="/product/${product.slug}" class="font-serif text-xs md:text-sm font-bold text-gray-900 hover:text-[#a28e46] uppercase tracking-wider text-center block leading-tight line-clamp-1 no-underline transition-colors mb-1.5" title="${product.name}">
                        ${product.name}
                    </a>
                    
                    <!-- Prices -->
                    <div class="flex items-center justify-center gap-2 font-bold text-xs md:text-sm">
                        ${discountPercent > 0 ? `<span class="text-gray-400 line-through text-xs font-normal">৳ ${price.toLocaleString()}</span>` : ''}
                        <span class="text-[#a28e46]">৳ ${finalPrice.toLocaleString()}</span>
                    </div>
                </div>
            </div>
        </li>`;
    } catch (e) {
        console.error('Error rendering product card:', e);
        return '';
    }
}

// Splide instances cache
const splideInstances = {};

// Initialize Splide for Product Sections
function fetchAndMountProductSplide(endpoint, wrapperId, listId, fallbackId) {
    const wrapper = document.getElementById(wrapperId);
    const listEl = document.getElementById(listId);
    const fallback = document.getElementById(fallbackId);

    if (!wrapper || !listEl) return;

    if (fallback) {
        fallback.innerHTML = Array.from({ length: 4 }, () => `
            <div class="bg-white border-0 rounded p-2 animate-pulse text-center">
                <div class="aspect-[4/5] bg-stone-100 rounded mb-2.5"></div>
                <div class="h-3 bg-stone-200 rounded w-1/3 mx-auto mb-1.5"></div>
                <div class="h-3.5 bg-stone-200 rounded w-3/4 mx-auto mb-1.5"></div>
                <div class="h-3 bg-stone-200 rounded w-1/4 mx-auto"></div>
            </div>
        `).join('');
        fallback.style.display = 'grid';
    }

    fetch(endpoint, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        const products = data.success ? data.data : (Array.isArray(data) ? data : []);

        if (!products || products.length === 0) {
            if (fallback) fallback.style.display = 'none';
            if (wrapper) wrapper.style.display = 'none';
            return;
        }

        if (fallback) fallback.style.display = 'none';

        listEl.innerHTML = products.map(p => renderHarosaProductCard(p)).join('');

        const perPageCalc = window.innerWidth >= 1200 ? 4 : window.innerWidth >= 992 ? 3 : 2;
        if (products.length > 0 && products.length < perPageCalc * 2) {
            listEl.innerHTML = listEl.innerHTML.repeat(Math.ceil((perPageCalc * 2) / products.length));
        }

        wrapper.style.visibility = 'visible';
        requestAnimationFrame(() => {
            if (splideInstances[wrapperId]) {
                try { splideInstances[wrapperId].destroy(); } catch(e){}
            }

            const splide = new Splide(wrapper, {
                type: 'loop',
                perPage: perPageCalc,
                gap: '20px',
                pagination: false,
                arrows: true,
                autoplay: true,
                interval: 4000,
                pauseOnHover: true,
                rewind: true,
                breakpoints: {
                    1199: { perPage: 3 },
                    991: { perPage: 2 },
                    575: { perPage: 2 }
                }
            });
            splide.mount();
            splideInstances[wrapperId] = splide;
        });
    })
    .catch(err => {
        console.error(`Failed to load products from ${endpoint}:`, err);
        if (fallback) fallback.style.display = 'none';
        if (wrapper) wrapper.style.display = 'none';
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // 1. Hero Splide
    const heroEl = document.getElementById('heroSplide');
    if (heroEl && !heroEl.__splideMounted) {
        try {
            const slides = heroEl.querySelectorAll('.splide__slide');
            const hasMultiple = slides.length > 1;
            const heroSplide = new Splide(heroEl, {
                type: hasMultiple ? 'loop' : 'slide',
                perPage: 1,
                perMove: 1,
                width: '100%',
                autoWidth: false,
                autoplay: hasMultiple,
                interval: 5000,
                pauseOnHover: true,
                arrows: hasMultiple,
                pagination: hasMultiple,
                drag: hasMultiple,
                rewind: true,
                speed: 500,
            });
            heroSplide.mount();
            heroEl.__splideMounted = true;

            // Recalculate once images or page finish loading so initial position is 100% accurate
            window.addEventListener('load', function () {
                heroSplide.refresh();
            });
        } catch (e) {
            console.error('Failed to mount hero Splide:', e);
        }
    }

    // 2. Featured Category Splide
    const catEl = document.getElementById('categorySplide');
    if (catEl && !catEl.__splideMounted) {
        try {
            const catSplide = new Splide(catEl, {
                type: 'loop',
                perPage: 4,
                gap: '16px',
                pagination: false,
                arrows: true,
                breakpoints: {
                    1199: { perPage: 3 },
                    767: { perPage: 2 },
                    575: { perPage: 2 }
                }
            });
            catSplide.mount();
            catEl.__splideMounted = true;
        } catch (e) {
            console.error('Failed to mount category Splide:', e);
        }
    }

    // 3. Mount initial tab (New Arrivals) & Weekly Deals Section
    fetchAndMountProductSplide('/api/products/new-arrivals', 'newArrivalsSplide', 'newArrivalsSplideList', 'newArrivalsFallback');
    fetchAndMountProductSplide('/api/products/best-deals', 'weeklyDealsSplide', 'weeklyDealsSplideList', 'weeklyDealsFallback');

    // 4. Tab Switcher Logic (NEW ARRIVAL, BESTSELLER, FEATURED PRODUCTS)
    const tabButtons = document.querySelectorAll('.harosa-tab-btn');
    const tabPanes = document.querySelectorAll('.harosa-tab-pane');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-tab-target');
            if (!targetId) return;

            tabButtons.forEach(b => {
                b.classList.remove('active', 'text-[#a28e46]');
                b.classList.add('text-gray-400');
                const dot = b.querySelector('.dot-indicator, span:first-child');
                if (dot) dot.classList.replace('bg-[#a28e46]', 'bg-gray-300');
            });

            this.classList.add('active', 'text-[#a28e46]');
            this.classList.remove('text-gray-400');
            const activeDot = this.querySelector('.dot-indicator, span:first-child');
            if (activeDot) activeDot.classList.replace('bg-gray-300', 'bg-[#a28e46]');

            tabPanes.forEach(pane => pane.classList.add('hidden'));
            const targetPane = document.getElementById(targetId);
            if (targetPane) targetPane.classList.remove('hidden');

            if (targetId === 'tab-new-arrivals') {
                if (!splideInstances['newArrivalsSplide']) {
                    fetchAndMountProductSplide('/api/products/new-arrivals', 'newArrivalsSplide', 'newArrivalsSplideList', 'newArrivalsFallback');
                }
            } else if (targetId === 'tab-bestseller') {
                if (!splideInstances['mostSoldSplide']) {
                    fetchAndMountProductSplide('/api/products/most-sold', 'mostSoldSplide', 'mostSoldSplideList', 'mostSoldFallback');
                }
            } else if (targetId === 'tab-featured') {
                if (!splideInstances['bestDealsSplide']) {
                    fetchAndMountProductSplide('/api/products/best-deals', 'bestDealsSplide', 'bestDealsSplideList', 'bestDealsFallback');
                }
            }
        });
    });

    // 5. Vlog Splide
    const vlogEl = document.getElementById('vlogSplide');
    if (vlogEl && !vlogEl.__splideMounted) {
        try {
            const vlogSplide = new Splide(vlogEl, {
                perPage: 2,
                gap: '20px',
                pagination: false,
                arrows: true,
                drag: false,
                breakpoints: {
                    991: { perPage: 1 }
                }
            });
            vlogSplide.mount();
            vlogEl.__splideMounted = true;
        } catch (e) {
            console.error('Failed to mount vlog Splide:', e);
        }
    }
});
