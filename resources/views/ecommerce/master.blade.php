@include('ecommerce.components.header')
@include('ecommerce.components.navbar')

<!-- Main Content Container -->
<div id="main-content-container" class="min-h-screen">
    @yield('main-section')
    @stack('scripts')
</div>

@include('ecommerce.components.footer')
@include('ecommerce.components.quick-variation-modal')

<!-- Scroll to Top Button -->
<button id="scrollToTopBtn" class="scroll-to-top-btn" title="Scroll to top" aria-label="Scroll to top">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Global Toast Container -->
<div id="toast-container"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ── 1. Global Toast Notification Helper ──
        window.showToast = function (message, type = 'success') {
            const container = document.getElementById('toast-container') || (function() {
                const c = document.createElement('div');
                c.id = 'toast-container';
                document.body.appendChild(c);
                return c;
            })();

            const toast = document.createElement('div');
            toast.className = 'custom-toast ' + type;
            toast.innerHTML = `
                <div class="toast-content">
                    <span class="toast-icon">${type === 'error' ? '❌' : type === 'warning' ? '⚠️' : '✓'}</span>
                    <span class="toast-message">${message}</span>
                    <button class="toast-close" type="button" aria-label="Close">&times;</button>
                </div>
                <div class="toast-progress"></div>
            `;

            container.appendChild(toast);

            // Animate In
            setTimeout(() => toast.classList.add('show'), 10);
            setTimeout(() => {
                const progress = toast.querySelector('.toast-progress');
                if (progress) progress.style.transform = 'scaleX(0)';
            }, 10);

            const removeToast = () => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 400);
            };

            const timeout = setTimeout(removeToast, 3200);

            const closeBtn = toast.querySelector('.toast-close');
            if (closeBtn) {
                closeBtn.onclick = () => {
                    clearTimeout(timeout);
                    removeToast();
                };
            }
        };

        // ── 2. Global Cart Quantity Badge Synchronizer ──
        window.updateCartQtyBadge = function () {
            if (typeof updateCartCount === 'function') {
                updateCartCount();
            } else {
                fetch('/cart/qty-sum', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data && data.qty_sum !== undefined) {
                        const count = data.qty_sum;
                        document.querySelectorAll('.nav-cart-count, .qi-badge.nav-cart-count').forEach(el => {
                            el.textContent = count;
                        });
                    }
                })
                .catch(() => {});
            }
        };

        // Initialize badges on load
        if (typeof window.updateCartQtyBadge === 'function') window.updateCartQtyBadge();
        if (typeof window.updateWishlistCount === 'function') window.updateWishlistCount();

        // ── 3. Global Wishlist Toggle Handler ──
        window.toggleWishlist = function (productId, btnEl = null, onSuccess = null) {
            const isAuth = document.querySelector('meta[name="auth-check"]')?.getAttribute('content') === '1';
            if (!isAuth) {
                showToast('Please login first to use wishlist.', 'error');
                return;
            }

            const buttons = document.querySelectorAll(`[data-product-id="${productId}"].product-wishlist-top, 
                                                     [data-product-id="${productId}"].pd-main-wishlist-btn,
                                                     [data-product-id="${productId}"].pd-card-wishlist,
                                                     [data-product-id="${productId}"].wishlist-btn`);
            
            const primaryButton = btnEl || buttons[0];
            const isActive = primaryButton ? primaryButton.classList.contains('active') : false;

            // Loading state
            buttons.forEach(btn => {
                btn.disabled = true;
                const icon = btn.querySelector('i');
                if (icon) {
                    btn._originalClass = icon.className;
                    icon.className = 'fas fa-spinner fa-spin';
                }
            });

            fetch(`/add-remove-wishlist/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const nowActive = !isActive;
                    buttons.forEach(btn => {
                        btn.classList.toggle('active', nowActive);
                        const icon = btn.querySelector('i');
                        if (icon) icon.className = nowActive ? 'fas fa-heart text-red-500' : 'far fa-heart';
                    });

                    showToast(nowActive ? 'Added to wishlist!' : 'Removed from wishlist!', 'success');
                    if (typeof updateWishlistCount === 'function') updateWishlistCount();
                    if (typeof onSuccess === 'function') onSuccess(nowActive, productId);
                } else {
                    throw new Error(data.message || 'Failed to update wishlist');
                }
            })
            .catch(err => {
                console.error('Wishlist error:', err);
                showToast('Error updating wishlist', 'error');
                buttons.forEach(btn => {
                    const icon = btn.querySelector('i');
                    if (icon && btn._originalClass) icon.className = btn._originalClass;
                });
            })
            .finally(() => {
                buttons.forEach(btn => btn.disabled = false);
            });
        };

        // ── 4. Global Add-To-Cart Event Handler ──
        window.globalCartHandler = function (e) {
            const btn = e.target.closest('.btn-add-cart, .pd-btn-cart');
            if (!btn || btn.tagName === 'A') return;

            const hasStock = btn.getAttribute('data-has-stock');
            if (hasStock === 'false') {
                e.preventDefault();
                e.stopPropagation();
                showToast('This product is out of stock!', 'warning');
                return;
            }

            e.preventDefault();
            e.stopPropagation();

            if (btn.disabled || btn.getAttribute('data-processing') === 'true') {
                return;
            }

            btn.setAttribute('data-processing', 'true');
            btn.disabled = true;

            const productId = btn.getAttribute('data-product-id');
            if (!productId) {
                btn.disabled = false;
                btn.removeAttribute('data-processing');
                showToast('Error: Product ID not found', 'error');
                return;
            }

            const qtyInput = document.getElementById('quantityInput');
            const qty = qtyInput ? (parseInt(qtyInput.value, 10) || 1) : 1;

            const data = new URLSearchParams();
            data.append('qty', qty.toString());

            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

            const isProductPage = window.location.pathname.includes('/product/');
            const endpoint = isProductPage ? `/cart/add-page/${productId}` : `/cart/add/${productId}`;

            // Check for variation selections on detail page
            if (isProductPage) {
                const hasVariations = document.querySelector('[data-has-variations="true"]') !== null ||
                                      document.querySelector('[data-has-variations="1"]') !== null ||
                                      document.querySelectorAll('.color-option, .size-option, .variation-option, .pd-color-btn, .pd-size-btn').length > 0;

                if (hasVariations) {
                    const variationIdEl = document.getElementById('selected-variation-id');
                    const selectedVariationId = variationIdEl ? variationIdEl.value : null;

                    if (!selectedVariationId || selectedVariationId === '' || selectedVariationId === '0') {
                        showToast('Please select product options (Color/Size) before adding to cart', 'error');
                        btn.disabled = false;
                        btn.removeAttribute('data-processing');
                        return;
                    }
                    data.append('variation_id', selectedVariationId);
                }
            }

            const reEnableBtn = () => {
                btn.disabled = false;
                btn.removeAttribute('data-processing');
            };

            const backupTimeout = setTimeout(reEnableBtn, 4000);

            fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: data.toString()
            })
            .then(res => {
                if (res.status === 401) {
                    window.location.href = '/login';
                    return null;
                }
                if (!res.ok) throw new Error(`HTTP error ${res.status}`);
                return res.json();
            })
            .then(resData => {
                if (!resData) return;

                if (resData.success) {
                    showToast(resData.message || 'Product added to cart successfully!', 'success');
                    if (typeof updateCartCount === 'function') updateCartCount();
                    if (typeof updateCartQtyBadge === 'function') updateCartQtyBadge();

                    // Google Tag Manager tracking
                    if (resData.product && window.dataLayer) {
                        window.dataLayer.push({
                            'event': 'add_to_cart',
                            'ecommerce': {
                                'currency': 'BDT',
                                'value': resData.product.price * (resData.qty || 1),
                                'items': [{
                                    'item_id': String(resData.product.id),
                                    'item_name': resData.product.name,
                                    'item_category': resData.product.category || '',
                                    'price': resData.product.price,
                                    'quantity': resData.qty || 1
                                }]
                            }
                        });
                    }
                } else if (resData.redirect) {
                    window.location.href = resData.redirect;
                } else {
                    showToast(resData.message || 'Failed to add item to cart', 'error');
                }
            })
            .catch(err => {
                console.error('Add to cart error:', err);
            })
            .finally(() => {
                clearTimeout(backupTimeout);
                reEnableBtn();
            });
        };

        window.handleGlobalAddToCart = function (productId, productName) {
            const dummyBtn = document.createElement('button');
            dummyBtn.className = 'btn-add-cart';
            dummyBtn.setAttribute('data-product-id', productId);
            dummyBtn.setAttribute('data-product-name', productName || 'Product');
            dummyBtn.setAttribute('data-has-stock', 'true');

            window.globalCartHandler({
                target: dummyBtn,
                preventDefault: function () {},
                stopPropagation: function () {}
            });
        };

        // Attach global cart click listener
        document.removeEventListener('click', window.globalCartHandler);
        document.addEventListener('click', window.globalCartHandler);

        // ── 5. Unstick Processing Buttons on Visibility Change ──
        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) {
                document.querySelectorAll('.btn-add-cart[data-processing="true"], .pd-btn-cart[data-processing="true"]').forEach(btn => {
                    btn.disabled = false;
                    btn.removeAttribute('data-processing');
                });
            }
        });

        // ── 6. Scroll-To-Top & Smart Header Behavior ──
        const scrollToTopBtn = document.getElementById('scrollToTopBtn');

        const handleScroll = function () {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            // To-Top Button Visibility
            if (scrollToTopBtn) {
                if (scrollTop > 350) {
                    scrollToTopBtn.classList.add('show');
                } else {
                    scrollToTopBtn.classList.remove('show');
                }
            }

            // Desktop Smart Header Header Collapse
            if (window.innerWidth > 992) {
                if (scrollTop > 32) {
                    document.body.classList.add('hide-upper-headers');
                } else {
                    document.body.classList.remove('hide-upper-headers');
                }
            }
        };

        window.addEventListener('scroll', handleScroll, { passive: true });

        if (scrollToTopBtn) {
            scrollToTopBtn.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // ── 7. Single-Submit Form Guard ──
        document.querySelectorAll('form:not([data-no-guard])').forEach(form => {
            form.addEventListener('submit', function () {
                const submitBtn = this.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                }
            });
        });
    });
</script>

</body>
</html>