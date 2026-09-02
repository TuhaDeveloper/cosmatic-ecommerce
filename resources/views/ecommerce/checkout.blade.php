@extends('ecommerce.master')

@section('title', 'Secure Checkout - Harosa Luxury Cosmetics')

@section('main-section')
<div class="bg-stone-50/60 min-h-screen pb-20">

    <!-- 1. Checkout Progress Bar & Header -->
    <div class="bg-white border-b border-stone-200/60 py-6 sm:py-8 mb-8">
        <div class="container mx-auto px-4 max-w-7xl">
            <!-- Progress Steps -->
            <div class="flex items-center justify-center max-w-md mx-auto mb-4">
                
                <!-- Step 1: Cart -->
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-stone-100 text-stone-500 flex items-center justify-center text-xs font-bold mb-1">
                        <i class="fa-solid fa-check text-[10px]"></i>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400">Cart</span>
                </div>

                <div class="w-12 sm:w-16 h-0.5 bg-[#a28e46] mx-2 -mt-4"></div>

                <!-- Step 2: Checkout (Active) -->
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-[#a28e46] text-white flex items-center justify-center text-xs font-bold shadow-sm mb-1 ring-4 ring-[#a28e46]/20">
                        <span>2</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#a28e46]">Checkout</span>
                </div>

                <div class="w-12 sm:w-16 h-0.5 bg-stone-200 mx-2 -mt-4"></div>

                <!-- Step 3: Complete -->
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-stone-100 text-stone-400 flex items-center justify-center text-xs font-bold mb-1">
                        <span>3</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400">Order Placed</span>
                </div>

            </div>

            <h1 class="font-serif text-xl sm:text-2xl font-bold text-center text-stone-900 uppercase tracking-wide">
                SECURE CHECKOUT
            </h1>
        </div>
    </div>

    <div class="container mx-auto px-4 max-w-7xl">
        
        {{-- Error & Session Alerts --}}
        @if(session('error'))
            <div class="mb-6 p-4 rounded-sm bg-rose-50 text-rose-800 border border-rose-200 text-xs font-medium flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 p-4 rounded-sm bg-rose-50 text-rose-800 border border-rose-200 text-xs">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="checkoutForm" action="{{ route('order.make') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            @csrf

            <!-- Left: Customer Information & Shipping Forms (Cols 7/8) -->
            <div class="lg:col-span-7 space-y-6">

                <!-- 1. Customer & Shipping Details -->
                <div class="bg-white border border-stone-200/80 rounded-sm p-6 sm:p-7 shadow-sm">
                    <div class="flex items-center justify-between pb-4 mb-5 border-b border-stone-100">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-xs font-bold border border-[#a28e46]/20">1</span>
                            <h2 class="font-serif font-bold text-sm uppercase tracking-wider text-stone-900">
                                Contact & Delivery Address
                            </h2>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-bold text-stone-700 uppercase tracking-wider mb-1.5">First Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="first_name" value="{{ optional(auth()->user())->first_name }}" required placeholder="e.g. Ayesha" class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block font-bold text-stone-700 uppercase tracking-wider mb-1.5">Last Name</label>
                                <input type="text" name="last_name" value="{{ optional(auth()->user())->last_name }}" placeholder="e.g. Khan" class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:outline-none transition-colors">
                            </div>
                        </div>

                        <input type="hidden" name="email" value="{{ optional(auth()->user())->email }}">

                        <div>
                            <label class="block font-bold text-stone-700 uppercase tracking-wider mb-1.5">Phone Number <span class="text-rose-500">*</span></label>
                            <input type="tel" name="phone" value="{{ optional(optional(auth()->user())->customer)->phone }}" required placeholder="e.g. 01700-000000" class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:outline-none transition-colors">
                        </div>

                        <div>
                            <label class="block font-bold text-stone-700 uppercase tracking-wider mb-1.5">Full Street Address <span class="text-rose-500">*</span></label>
                            <input type="text" name="billing_address_1" value="{{ optional(optional(auth()->user())->customer)->address_1 }}" required placeholder="House, Road, Area, Landmark" class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:outline-none transition-colors">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- City Search Wrapper -->
                            <div class="relative z-30">
                                <label class="block font-bold text-stone-700 uppercase tracking-wider mb-1.5">City / District <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <input type="text" 
                                           id="billing_city_search" 
                                           placeholder="Search & select city (e.g. Dhaka)" 
                                           autocomplete="off"
                                           value="{{ optional(optional(auth()->user())->customer)->city }}"
                                           required
                                           class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:outline-none transition-colors">
                                    <input type="hidden" name="billing_city_id" id="billing_city_id" value="">
                                    <input type="hidden" name="billing_city" id="billing_city" value="{{ optional(optional(auth()->user())->customer)->city }}">
                                    
                                    <!-- Dropdown list -->
                                    <div id="billing_city_dropdown" class="absolute top-full left-0 right-0 bg-white border border-[#a28e46] shadow-2xl max-h-56 overflow-y-auto z-50 rounded-b-sm hidden"></div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block font-bold text-stone-700 uppercase tracking-wider mb-1.5">Postal Code (Optional)</label>
                                <input type="text" name="billing_zip_code" placeholder="e.g. 1212" class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:outline-none transition-colors">
                            </div>
                        </div>

                        <input type="hidden" name="billing_state" value="">
                        <input type="hidden" name="billing_address_2" value="">
                        <input type="hidden" name="billing_country" value="Bangladesh">
                        <input type="hidden" name="shipping_address_2" value="">
                        <input type="hidden" name="shipping_country" value="Bangladesh">

                        <!-- Same as Billing Toggle -->
                        <div class="pt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="checkbox" id="sameAsBilling" checked class="rounded border-stone-300 text-[#a28e46] focus:ring-0">
                                <span class="text-xs text-stone-700 font-medium">Shipping address is the same as billing address</span>
                            </label>
                        </div>

                        <!-- Different Shipping Section -->
                        <div id="billingAddressSection" class="hidden space-y-4 pt-4 border-t border-stone-100">
                            <h3 class="font-serif font-bold text-xs uppercase tracking-wider text-stone-900">Separate Shipping Address</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-stone-700 uppercase tracking-wider mb-1.5">Recipient First Name</label>
                                    <input type="text" name="shipping_first_name" class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] outline-none">
                                </div>
                                <div>
                                    <label class="block font-bold text-stone-700 uppercase tracking-wider mb-1.5">Recipient Last Name</label>
                                    <input type="text" name="shipping_last_name" class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block font-bold text-stone-700 uppercase tracking-wider mb-1.5">Recipient Phone Number</label>
                                <input type="tel" name="shipping_phone" class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] outline-none">
                            </div>
                            <div>
                                <label class="block font-bold text-stone-700 uppercase tracking-wider mb-1.5">Recipient Address</label>
                                <input type="text" name="shipping_address_1" class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] outline-none">
                            </div>
                            <div class="relative z-20">
                                <label class="block font-bold text-stone-700 uppercase tracking-wider mb-1.5">Shipping City</label>
                                <div class="relative">
                                    <input type="text" id="shipping_city_search" placeholder="Search shipping city..." class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] outline-none">
                                    <input type="hidden" name="shipping_city_id" id="shipping_city_id">
                                    <input type="hidden" name="shipping_city" id="shipping_city">
                                    <div id="shipping_city_dropdown" class="absolute top-full left-0 right-0 bg-white border border-[#a28e46] shadow-2xl max-h-56 overflow-y-auto z-50 rounded-b-sm hidden"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- 2. Shipping Delivery Method -->
                <div class="bg-white border border-stone-200/80 rounded-sm p-6 sm:p-7 shadow-sm">
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-stone-100">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-xs font-bold border border-[#a28e46]/20">2</span>
                            <h2 class="font-serif font-bold text-sm uppercase tracking-wider text-stone-900">
                                Delivery Method
                            </h2>
                        </div>
                    </div>

                    @if($hasProductFreeDelivery)
                        <div class="mb-4 p-3 rounded-sm bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-medium flex items-center gap-2">
                            <i class="fa-solid fa-truck-fast text-emerald-600"></i>
                            <span><strong>Complimentary Free Delivery!</strong> Your bag qualifies for free shipping.</span>
                        </div>
                    @endif

                    <div class="shipping-options space-y-2.5 text-xs">
                        @foreach($shippingMethods as $index => $method)
                            <label for="shipping_{{ $method->id }}" class="flex items-center justify-between p-3.5 border border-stone-200 rounded-sm hover:border-[#a28e46] cursor-pointer transition-all has-[:checked]:border-[#a28e46] has-[:checked]:bg-[#faf7f0]/40">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="shipping_method" id="shipping_{{ $method->id }}" value="{{ $method->id }}" {{ $index === 0 ? 'checked' : '' }} class="text-[#a28e46] focus:ring-0">
                                    <div>
                                        <span class="font-bold text-stone-900 block">{{ $method->name }}</span>
                                        <span class="text-[11px] text-stone-500">{{ $method->delivery_time ?? $method->description }}</span>
                                    </div>
                                </div>
                                <span class="font-mono font-bold text-stone-900 shipping-price">
                                    @if($hasProductFreeDelivery)
                                        <span class="text-emerald-600">Free</span>
                                    @else
                                        {{ number_format($method->cost, 2) }}৳
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 3. Payment Method -->
                <div class="bg-white border border-stone-200/80 rounded-sm p-6 sm:p-7 shadow-sm">
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-stone-100">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-xs font-bold border border-[#a28e46]/20">3</span>
                            <h2 class="font-serif font-bold text-sm uppercase tracking-wider text-stone-900">
                                Payment Method
                            </h2>
                        </div>
                    </div>

                    <div class="payment-options space-y-2.5 text-xs">
                        <!-- Cash on Delivery Option -->
                        <label for="cod" class="flex items-center justify-between p-4 border border-stone-200 rounded-sm hover:border-[#a28e46] cursor-pointer transition-all has-[:checked]:border-[#a28e46] has-[:checked]:bg-[#faf7f0]/40">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" id="cod" value="cash" checked class="text-[#a28e46] focus:ring-0">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-stone-100 text-[#a28e46] flex items-center justify-center text-sm">
                                        <i class="fa-solid fa-money-bill-wave"></i>
                                    </div>
                                    <div>
                                        <span class="font-bold text-stone-900 block">Cash on Delivery (COD)</span>
                                        <span class="text-[11px] text-stone-500">Pay conveniently with cash upon receiving your order</span>
                                    </div>
                                </div>
                            </div>
                            <i class="fa-solid fa-shield-check text-[#a28e46] text-base"></i>
                        </label>
                    </div>
                </div>

                <!-- 4. Order Note -->
                <div class="bg-white border border-stone-200/80 rounded-sm p-6 sm:p-7 shadow-sm">
                    <h2 class="font-serif font-bold text-xs uppercase tracking-wider text-stone-900 mb-2 flex items-center gap-2">
                        <i class="fa-regular fa-note-sticky text-[#a28e46]"></i>
                        <span>Order Notes (Optional)</span>
                    </h2>
                    <textarea name="notes" rows="2" placeholder="Any special delivery instructions (e.g. Call before arrival, leave at reception)..." class="w-full px-3.5 py-2.5 text-xs bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:outline-none resize-none">{{ old('notes') }}</textarea>
                </div>

            </div>

            <!-- Right: Order Summary Sidebar (Cols 5/4) -->
            <div class="lg:col-span-5 sticky top-24 space-y-6">
                
                <div class="bg-white border border-stone-200/90 rounded-sm shadow-md p-6 sm:p-7">
                    <h3 class="font-serif font-bold text-sm uppercase tracking-wider text-stone-900 pb-3.5 mb-4 border-b border-stone-100 flex items-center justify-between">
                        <span>Order Summary</span>
                        <span class="text-xs font-mono font-semibold text-[#a28e46]">{{ $carts->count() }} {{ $carts->count() === 1 ? 'Item' : 'Items' }}</span>
                    </h3>

                    <!-- Cart Item Breakdown List -->
                    <div class="space-y-3.5 max-h-60 overflow-y-auto pr-1 pb-4 border-b border-stone-100 scrollbar-thin">
                        @foreach ($carts as $cart)
                            @php
                                $price = $cart->variation ? $cart->variation->effective_price : $cart->product->effective_price;
                                $cartImage = $cart->product->image ? asset($cart->product->image) : asset('static/default-product.jpg');
                                $isStockInvalid = $cart->qty > ($cart->max_stock ?? 0);
                            @endphp
                            <div class="flex items-center gap-3 text-xs {{ $isStockInvalid ? 'opacity-70 bg-rose-50/50 p-2 rounded' : '' }}">
                                <div class="w-12 h-14 bg-stone-50 border border-stone-200 rounded-sm overflow-hidden flex-shrink-0">
                                    <img src="{{ $cartImage }}" alt="Product" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="font-medium text-stone-900 truncate leading-tight mb-0.5">
                                        {{ $cart->product->name }}
                                    </h4>
                                    @if($cart->variation)
                                        <span class="text-[10px] text-stone-400 block truncate">
                                            {{ $cart->variation->combinations->map(function($c) { return $c->attribute->name . ': ' . $c->attributeValue->value; })->join(', ') }}
                                        </span>
                                    @endif
                                    <div class="flex items-center gap-2 mt-0.5 text-[11px] text-stone-500 font-mono">
                                        <span>Qty: {{ $cart->qty }}</span>
                                        @if($isStockInvalid)
                                            <span class="text-[10px] font-bold text-rose-600 bg-rose-100 px-1.5 py-0.2 rounded">
                                                Max stock: {{ $cart->max_stock ?? 0 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <span class="font-mono font-bold text-stone-900 flex-shrink-0">
                                    {{ number_format($cart->qty * $price, 2) }}৳
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Promo Code Application Box -->
                    <div class="py-4 border-b border-stone-100">
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-stone-500 mb-1.5">Have a Promo Coupon?</label>
                        <div class="flex gap-2">
                            <input type="text" id="coupon_code" name="coupon_code" placeholder="DISCOUNT CODE" class="flex-grow px-3 py-2 text-xs bg-stone-50 border border-stone-300 rounded-sm uppercase tracking-wider font-mono focus:border-[#a28e46] focus:bg-white focus:outline-none">
                            <button type="button" id="applyCouponBtn" class="bg-stone-900 hover:bg-black text-white font-bold text-xs uppercase tracking-wider px-4 py-2 rounded-sm transition-colors cursor-pointer focus:outline-none">
                                Apply
                            </button>
                        </div>
                        <div id="couponMessage" class="hidden mt-2 p-2 rounded text-[11px] font-medium"></div>
                        <input type="hidden" id="applied_coupon_discount" name="applied_coupon_discount" value="0">
                    </div>

                    <!-- Cost Breakdown Rows -->
                    <div class="py-4 space-y-2.5 text-xs text-stone-600 border-b border-stone-100">
                        <div class="flex justify-between items-center">
                            <span>Subtotal</span>
                            <span id="subtotalDisplay" class="font-mono font-bold text-stone-900">{{ number_format($cartTotal, 2) }}৳</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Shipping</span>
                            <span id="shippingDisplay" class="font-mono font-bold text-stone-900 {{ $hasProductFreeDelivery ? 'text-emerald-600' : '' }}">
                                @if($hasProductFreeDelivery)
                                    Free Delivery
                                @else
                                    {{ number_format($initialShippingCost, 2) }}৳
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Tax (VAT)</span>
                            <span id="taxDisplay" class="font-mono font-bold text-stone-900">{{ number_format($cartTotal * $taxRate, 2) }}৳</span>
                        </div>
                        <div class="flex justify-between items-center text-emerald-600 hidden" id="couponDiscountRow">
                            <span>Coupon Discount</span>
                            <span id="couponDiscountAmount" class="font-mono font-bold">-0.00৳</span>
                        </div>
                    </div>

                    <!-- Total Amount Due -->
                    <div class="pt-4 pb-6 flex justify-between items-baseline">
                        <span class="font-serif font-bold text-sm uppercase tracking-wider text-stone-900">Total Payable</span>
                        <span id="totalDisplay" class="font-serif text-xl sm:text-2xl font-bold text-[#a28e46]">
                            {{ number_format($cartTotal + ($cartTotal * $taxRate) + $initialShippingCost, 2) }}৳
                        </span>
                    </div>

                    <!-- Place Order Button -->
                    @php
                        $hasInvalidStock = $carts->contains(function($c) {
                            return $c->qty > ($c->max_stock ?? 0);
                        });
                    @endphp

                    @if($hasInvalidStock)
                        <div class="mb-4 p-3 bg-amber-50 border border-amber-200 text-amber-800 text-xs rounded-sm flex items-center justify-between">
                            <span>Some items exceed stock limits.</span>
                            <a href="javascript:void(0)" onclick="openCartDrawer()" class="font-bold underline">Edit Cart</a>
                        </div>
                    @endif

                    <button type="submit" 
                            class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest py-3.5 rounded-none shadow-md hover:shadow-lg transition-all cursor-pointer focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                            {{ $hasInvalidStock ? 'disabled' : '' }}>
                        <i class="fa-solid fa-lock text-xs"></i>
                        <span id="placeOrderText">
                            @if($hasInvalidStock)
                                Adjust Stock Limits
                            @else
                                PLACE ORDER - {{ number_format($cartTotal + ($cartTotal * $taxRate) + $initialShippingCost, 2) }}৳
                            @endif
                        </span>
                    </button>

                    <!-- Trust Badges -->
                    <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-around text-[10px] text-stone-500 text-center">
                        <div class="flex flex-col items-center gap-1">
                            <i class="fa-solid fa-shield-halved text-[#a28e46] text-sm"></i>
                            <span>SSL Secured</span>
                        </div>
                        <div class="flex flex-col items-center gap-1">
                            <i class="fa-solid fa-certificate text-[#a28e46] text-sm"></i>
                            <span>100% Authentic</span>
                        </div>
                        <div class="flex flex-col items-center gap-1">
                            <i class="fa-solid fa-rotate-left text-[#a28e46] text-sm"></i>
                            <span>Easy Returns</span>
                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- Order Processing Modal Overlay -->
<div id="orderProcessingOverlay" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[999999] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-sm p-8 sm:p-10 max-w-sm w-full text-center shadow-2xl">
        <div class="w-14 h-14 border-3 border-stone-200 border-t-[#a28e46] rounded-full animate-spin mx-auto mb-5"></div>
        <h3 class="font-serif font-bold text-lg text-stone-900 uppercase tracking-wide mb-2">Processing Order</h3>
        <p class="text-xs text-stone-500 leading-relaxed mb-4" id="processingMessage">
            Please wait while we secure your luxury reservation...
        </p>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hasProductFreeDelivery = {{ $hasProductFreeDelivery ? 'true' : 'false' }};
        let couponProvidesFreeDelivery = false;
        let appliedCouponDiscount = 0;

        // 1. City Search Autocomplete
        function initCitySearch(inputId, dropdownId, cityIdInputId, cityNameInputId, isBilling = true) {
            const input = document.getElementById(inputId);
            const dropdown = document.getElementById(dropdownId);
            const cityIdInput = document.getElementById(cityIdInputId);
            const cityNameInput = document.getElementById(cityNameInputId);

            if (!input || !dropdown) return;
            let timeout;

            input.addEventListener('input', function() {
                const query = this.value.trim();
                clearTimeout(timeout);

                if (query.length < 2) {
                    dropdown.classList.add('hidden');
                    if (cityIdInput) cityIdInput.value = '';
                    return;
                }

                dropdown.innerHTML = '<div class="p-3 text-xs text-stone-400 text-center">Searching cities...</div>';
                dropdown.classList.remove('hidden');

                timeout = setTimeout(async () => {
                    try {
                        const res = await fetch(`{{ route('api.cities.search') }}?q=${encodeURIComponent(query)}`);
                        const data = await res.json();

                        if (data.cities && data.cities.length > 0) {
                            dropdown.innerHTML = data.cities.map(city => `
                                <div class="px-3.5 py-2.5 hover:bg-[#faf7f0] cursor-pointer border-b border-stone-100 last:border-b-0 city-item" data-id="${city.id}" data-name="${city.name}" data-display="${city.display_name}">
                                    <div class="font-bold text-stone-800">${city.name}</div>
                                    <div class="text-[10px] text-stone-400">${city.display_name}</div>
                                </div>
                            `).join('');

                            dropdown.querySelectorAll('.city-item').forEach(item => {
                                item.addEventListener('click', function() {
                                    const id = this.getAttribute('data-id');
                                    const name = this.getAttribute('data-name');
                                    const display = this.getAttribute('data-display');
                                    
                                    input.value = display;
                                    if (cityIdInput) cityIdInput.value = id;
                                    if (cityNameInput) cityNameInput.value = name;
                                    dropdown.classList.add('hidden');

                                    if (isBilling) {
                                        updateShippingMethods(id);
                                    }
                                });
                            });
                        } else {
                            dropdown.innerHTML = '<div class="p-3 text-xs text-stone-400 text-center">No matching cities found</div>';
                        }
                    } catch(err) {
                        console.error('City search error:', err);
                        dropdown.classList.add('hidden');
                    }
                }, 300);
            });

            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        }

        initCitySearch('billing_city_search', 'billing_city_dropdown', 'billing_city_id', 'billing_city', true);
        initCitySearch('shipping_city_search', 'shipping_city_dropdown', 'shipping_city_id', 'shipping_city', false);

        // 2. Same as Billing Address Toggle
        const sameAsBilling = document.getElementById('sameAsBilling');
        const billingAddressSection = document.getElementById('billingAddressSection');
        if (sameAsBilling && billingAddressSection) {
            sameAsBilling.addEventListener('change', function() {
                if (this.checked) {
                    billingAddressSection.classList.add('hidden');
                } else {
                    billingAddressSection.classList.remove('hidden');
                }
            });
        }

        // 3. Update Shipping Methods via API
        async function updateShippingMethods(cityId) {
            const url = cityId ? `{{ route('api.shipping.methods.city') }}?city_id=${cityId}` : `{{ route('api.shipping.methods.city') }}`;
            try {
                const res = await fetch(url);
                const data = await res.json();
                if (data.shipping_methods && data.shipping_methods.length > 0) {
                    const container = document.querySelector('.shipping-options');
                    if (container) {
                        container.innerHTML = data.shipping_methods.map((method, idx) => `
                            <label for="shipping_${method.id}" class="flex items-center justify-between p-3.5 border border-stone-200 rounded-sm hover:border-[#a28e46] cursor-pointer transition-all has-[:checked]:border-[#a28e46] has-[:checked]:bg-[#faf7f0]/40">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="shipping_method" id="shipping_${method.id}" value="${method.id}" ${idx === 0 ? 'checked' : ''} class="text-[#a28e46] focus:ring-0">
                                    <div>
                                        <span class="font-bold text-stone-900 block">${method.name}</span>
                                        <span class="text-[11px] text-stone-500">${method.delivery_time || method.description || ''}</span>
                                    </div>
                                </div>
                                <span class="font-mono font-bold text-stone-900 shipping-price">
                                    ${(couponProvidesFreeDelivery || hasProductFreeDelivery) ? '<span class="text-emerald-600">Free</span>' : method.formatted_cost + '৳'}
                                </span>
                            </label>
                        `).join('');

                        document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
                            radio.addEventListener('change', updateTotals);
                        });
                        updateTotals();
                    }
                }
            } catch(e) {
                console.error(e);
            }
        }

        // 4. Update Price Calculations
        function updateTotals() {
            const subtotal = {{ $cartTotal }};
            const tax = {{ $cartTotal * $taxRate }};
            const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
            let shippingCost = 0;

            if (selectedShipping) {
                const priceEl = selectedShipping.closest('label')?.querySelector('.shipping-price');
                if (priceEl) {
                    shippingCost = parseFloat(priceEl.textContent.replace(/[৳,Free]/g, '')) || 0;
                }
            }

            if (couponProvidesFreeDelivery || hasProductFreeDelivery) {
                shippingCost = 0;
            }

            const totalBeforeDiscount = subtotal + tax + shippingCost;
            const finalTotal = Math.max(0, totalBeforeDiscount - appliedCouponDiscount);

            const shipEl = document.getElementById('shippingDisplay');
            if (shipEl) {
                if (shippingCost === 0) {
                    shipEl.textContent = 'Free Delivery';
                    shipEl.classList.add('text-emerald-600');
                } else {
                    shipEl.textContent = `${shippingCost.toFixed(2)}৳`;
                    shipEl.classList.remove('text-emerald-600');
                }
            }

            const totEl = document.getElementById('totalDisplay');
            if (totEl) totEl.textContent = `${finalTotal.toFixed(2)}৳`;

            const btnText = document.getElementById('placeOrderText');
            if (btnText) btnText.textContent = `PLACE ORDER - ${finalTotal.toFixed(2)}৳`;
        }

        document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
            radio.addEventListener('change', updateTotals);
        });

        // 5. Coupon Application Logic
        const couponBtn = document.getElementById('applyCouponBtn');
        const couponInput = document.getElementById('coupon_code');
        const couponMsg = document.getElementById('couponMessage');

        if (couponBtn && couponInput) {
            couponBtn.addEventListener('click', async function() {
                const code = couponInput.value.trim().toUpperCase();
                if (!code) return;

                couponBtn.disabled = true;
                couponBtn.textContent = '...';

                try {
                    const res = await fetch('{{ route("api.coupons.validate") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ coupon_code: code, shipping_cost: 0 })
                    });
                    const data = await res.json();

                    if (data.valid) {
                        appliedCouponDiscount = parseFloat(data.discount) || 0;
                        couponProvidesFreeDelivery = !!data.free_delivery;
                        document.getElementById('applied_coupon_discount').value = appliedCouponDiscount;
                        
                        const row = document.getElementById('couponDiscountRow');
                        const amt = document.getElementById('couponDiscountAmount');
                        if (row && amt) {
                            row.classList.remove('hidden');
                            amt.textContent = `-${appliedCouponDiscount.toFixed(2)}৳`;
                        }

                        couponMsg.className = 'mt-2 p-2 rounded text-[11px] font-medium bg-emerald-50 text-emerald-800 border border-emerald-200 block';
                        couponMsg.textContent = data.message || 'Coupon applied successfully!';
                        couponBtn.textContent = 'Applied';
                    } else {
                        couponMsg.className = 'mt-2 p-2 rounded text-[11px] font-medium bg-rose-50 text-rose-800 border border-rose-200 block';
                        couponMsg.textContent = data.message || 'Invalid promo code.';
                        couponBtn.disabled = false;
                        couponBtn.textContent = 'Apply';
                    }
                    updateTotals();
                } catch(err) {
                    console.error(err);
                    couponBtn.disabled = false;
                    couponBtn.textContent = 'Apply';
                }
            });
        }

        // 6. Form Submission Overlay
        const form = document.getElementById('checkoutForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const overlay = document.getElementById('orderProcessingOverlay');
                if (overlay) overlay.classList.remove('hidden');
            });
        }
    });
</script>
@endpush
@endsection