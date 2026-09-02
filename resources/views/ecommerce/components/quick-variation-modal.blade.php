<!-- Quick Variation Selection Modal (100% Mobile & Desktop Optimized) -->
<div id="quickVariationModal" class="fixed inset-0 bg-black/60 backdrop-blur-[3px] z-[99999] flex items-end sm:items-center justify-center p-0 sm:p-4 opacity-0 pointer-events-none transition-opacity duration-300" onclick="closeQuickVariationModal(event)">
    <div class="bg-white rounded-t-2xl sm:rounded-md shadow-2xl max-w-lg w-full max-h-[88vh] overflow-hidden flex flex-col transform translate-y-full sm:translate-y-0 sm:scale-95 transition-transform duration-300 relative" onclick="event.stopPropagation()">
        
        <!-- Header / Close Button -->
        <div class="px-5 py-3.5 border-b border-stone-100 flex items-center justify-between flex-shrink-0">
            <span class="font-serif font-bold text-xs uppercase tracking-wider text-stone-700 flex items-center gap-1.5">
                <i class="fa-solid fa-sparkles text-[#a28e46] text-xs"></i> Select Options
            </span>
            <button type="button" class="w-7 h-7 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-600 flex items-center justify-center cursor-pointer transition-colors focus:outline-none" onclick="closeQuickVariationModal()">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>

        <!-- Scrollable Modal Body -->
        <div class="flex-grow overflow-y-auto p-4 sm:p-6">
            
            <!-- Loading State -->
            <div id="quickModalLoading" class="py-12 flex flex-col items-center justify-center text-center">
                <div class="w-8 h-8 border-2 border-stone-200 border-t-[#a28e46] rounded-full animate-spin mb-3"></div>
                <p class="text-xs text-stone-500 font-medium tracking-wide">Loading product options...</p>
            </div>

            <!-- Content Body (Injected dynamically) -->
            <div id="quickModalContent" class="hidden space-y-4">
                
                <!-- Product Overview Row (Compact Thumbnail + Title & Price on Mobile) -->
                <div class="flex items-start gap-3.5 sm:gap-4 pb-3 border-b border-stone-100">
                    <div class="w-20 h-24 sm:w-24 sm:h-28 flex-shrink-0 bg-stone-50 rounded overflow-hidden border border-stone-200/70">
                        <img id="quickModalImg" src="" alt="" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-grow min-w-0">
                        <span id="quickModalCategory" class="text-[10px] text-stone-400 font-medium uppercase tracking-wider block mb-0.5 truncate"></span>
                        <h3 id="quickModalTitle" class="font-serif font-bold text-sm sm:text-base text-stone-900 uppercase tracking-wide leading-snug line-clamp-2 mb-1.5"></h3>
                        <div class="flex items-center gap-2">
                            <span id="quickModalOriginalPrice" class="text-stone-400 line-through text-xs font-normal hidden"></span>
                            <span id="quickModalPrice" class="font-bold text-sm sm:text-base text-[#a28e46]"></span>
                        </div>
                    </div>
                </div>

                <!-- Variation Attributes Container -->
                <div id="quickModalAttributes" class="space-y-3">
                    <!-- Dynamic Attributes & Pill Buttons injected here -->
                </div>

                <!-- Quantity Stepper & Stock Status -->
                <div class="flex items-center justify-between pt-1">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xs font-semibold text-stone-700 uppercase tracking-wider">Quantity:</span>
                        <div class="inline-flex items-center border border-stone-300 rounded overflow-hidden bg-stone-50">
                            <button type="button" class="w-7 h-7 flex items-center justify-center text-stone-600 hover:bg-stone-200 transition-colors focus:outline-none" onclick="changeQuickModalQty(-1)">
                                <i class="fa-solid fa-minus text-[9px]"></i>
                            </button>
                            <input type="text" id="quickModalQty" value="1" readonly class="w-9 h-7 text-center text-xs font-bold text-stone-800 border-x border-stone-300 outline-none bg-transparent">
                            <button type="button" class="w-7 h-7 flex items-center justify-center text-stone-600 hover:bg-stone-200 transition-colors focus:outline-none" onclick="changeQuickModalQty(1)">
                                <i class="fa-solid fa-plus text-[9px]"></i>
                            </button>
                        </div>
                    </div>
                    <span id="quickModalStockStatus" class="text-[11px] text-emerald-600 font-medium"></span>
                </div>

            </div>
        </div>

        <!-- Sticky Footer Action -->
        <div class="p-4 bg-stone-50 border-t border-stone-200/80 flex-shrink-0 space-y-2">
            <button type="button" id="quickModalAddToCartBtn" class="w-full bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest py-3 px-5 rounded-sm shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer focus:outline-none active:scale-[0.99]" onclick="submitQuickModalAddToCart()">
                <i class="fa-solid fa-cart-shopping text-xs"></i>
                <span>CONFIRM ADD TO CART</span>
            </button>
            <a id="quickModalViewDetails" href="#" class="block text-center text-[11px] font-semibold text-stone-500 hover:text-[#a28e46] uppercase tracking-wider transition-colors no-underline">
                View Full Product Details <i class="fa-solid fa-arrow-right text-[8px] ml-0.5"></i>
            </a>
        </div>

    </div>
</div>
