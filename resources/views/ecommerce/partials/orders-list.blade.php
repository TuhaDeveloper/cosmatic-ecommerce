@forelse ($orders as $order)
    <div class="bg-white border border-stone-200/90 rounded-sm p-4 sm:p-6 mb-4 shadow-xs hover:shadow-md transition-all duration-200">
        
        <!-- Order Card Top Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-3 pb-3.5 sm:pb-4 mb-3.5 sm:mb-4 border-b border-stone-100">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-bold font-mono text-stone-900">#{{ $order->order_number }}</span>
                    @php
                        $displayStatus = ($order->invoice && $order->invoice->status === 'paid') ? 'paid' : $order->status;
                        $badgeStyles = match ($displayStatus) {
                            'paid' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                            'delivered' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                            'approved' => 'bg-amber-50 text-amber-700 border border-amber-200',
                            'shipping' => 'bg-sky-50 text-sky-700 border border-sky-200',
                            'cancelled' => 'bg-rose-50 text-rose-700 border border-rose-200',
                            default => 'bg-stone-100 text-stone-700 border border-stone-200'
                        };
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] sm:text-[10px] font-bold uppercase tracking-wider {{ $badgeStyles }}">
                        {{ ucfirst($displayStatus) }}
                    </span>
                </div>
                <div class="text-[10px] sm:text-[11px] text-stone-400 flex items-center gap-1.5 font-light">
                    <i class="fa-regular fa-clock text-[10px]"></i>
                    <span>Placed on {{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('M d, Y • h:i A') : '-' }}</span>
                </div>
            </div>

            <div class="flex sm:flex-col justify-between sm:text-right items-center sm:items-end pt-1 sm:pt-0 border-t sm:border-t-0 border-stone-50">
                <span class="text-[10px] sm:text-[11px] text-stone-400 uppercase tracking-wider block">Total Amount</span>
                <span class="font-serif font-bold text-sm sm:text-lg text-[#a28e46]">
                    ৳{{ number_format($order->total, 2) }}
                </span>
            </div>
        </div>

        <!-- Ordered Items Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2.5 sm:gap-3 mb-3.5 sm:mb-4">
            @foreach ($order->items as $item)
                <div class="flex items-center gap-2.5 sm:gap-3 p-2 sm:p-2.5 bg-stone-50/70 border border-stone-200/80 rounded-sm">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-sm overflow-hidden bg-white border border-stone-200 flex-shrink-0 flex items-center justify-center">
                        @if($item->product && $item->product->image)
                            <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-sparkles text-stone-300 text-xs sm:text-sm"></i>
                        @endif
                    </div>
                    <div class="flex-grow min-w-0">
                        @if($item->product)
                            <a href="{{ route('product.details', $item->product->slug) }}" class="block font-semibold text-xs text-stone-800 hover:text-[#a28e46] transition-colors truncate no-underline">
                                {{ $item->product->name }}
                            </a>
                        @else
                            <span class="block text-xs font-medium text-stone-400 italic truncate">Product Unavailable</span>
                        @endif
                        <div class="flex items-center justify-between text-[10px] sm:text-[11px] text-stone-500 mt-0.5">
                            <span>Qty: <strong class="text-stone-700">{{ number_format($item->quantity, 0) }}</strong></span>
                            <span class="text-[#8e7b39] font-medium">৳{{ number_format($item->price, 2) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Order Card Actions Footer -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-3 pt-3 border-t border-stone-100">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('order.details', urlencode($order->order_number)) }}"
                   class="inline-flex items-center justify-center gap-1.5 border border-[#a28e46] text-[#a28e46] hover:bg-[#a28e46] hover:text-white px-3 py-1.5 text-xs font-bold uppercase tracking-wider rounded-sm transition-all no-underline shadow-2xs">
                    <i class="fa-regular fa-eye text-[11px]"></i>
                    <span>View Details</span>
                </a>

                @if(($order->status === 'pending' || $order->status === 'approved') && !($order->invoice && $order->invoice->status === 'paid'))
                    <form action="{{ route('order.cancel', $order->id) }}?tab=orders" method="POST" class="inline cancel-order-form">
                        @csrf
                        <button type="button" class="btn-cancel-order inline-flex items-center justify-center gap-1.5 border border-amber-300 bg-amber-50/50 hover:bg-amber-100 text-amber-800 px-3 py-1.5 text-xs font-bold uppercase tracking-wider rounded-sm transition-all cursor-pointer"
                                data-bs-toggle="modal" data-bs-target="#cancelOrderModal" data-order-id="{{ $order->id }}">
                            <i class="fa-solid fa-ban text-[10px]"></i>
                            <span>Cancel</span>
                        </button>
                    </form>
                @endif

                @if(in_array($order->status, ['cancelled', 'pending']))
                    <form action="{{ route('order.delete', $order->id) }}?tab=orders" method="POST" class="inline delete-order-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-delete-order inline-flex items-center justify-center gap-1.5 border border-rose-200 bg-rose-50/50 hover:bg-rose-100 text-rose-700 px-3 py-1.5 text-xs font-bold uppercase tracking-wider rounded-sm transition-all cursor-pointer"
                                data-bs-toggle="modal" data-bs-target="#deleteOrderModal" data-order-id="{{ $order->id }}" data-order-number="{{ $order->order_number }}">
                            <i class="fa-regular fa-trash-can text-[10px]"></i>
                            <span>Delete</span>
                        </button>
                    </form>
                @endif
            </div>

            <!-- Payment status indicator -->
            <div class="text-[10px] sm:text-[11px] font-medium">
                @if($order->invoice && $order->invoice->status === 'paid')
                    <span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                        <i class="fa-solid fa-circle-check text-[9px] sm:text-[10px]"></i>
                        <span>Payment Verified</span>
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-stone-500 bg-stone-100 px-2.5 py-1 rounded-full border border-stone-200">
                        <i class="fa-regular fa-clock text-[9px] sm:text-[10px]"></i>
                        <span>Payment Pending</span>
                    </span>
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="bg-white border border-stone-200/90 rounded-sm p-8 sm:p-12 text-center my-3 sm:my-4">
        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-[#faf7f0] border border-[#a28e46]/30 text-[#a28e46] flex items-center justify-center text-xl sm:text-2xl mx-auto mb-3.5 sm:mb-4 shadow-xs">
            <i class="fa-solid fa-bag-shopping"></i>
        </div>
        <h3 class="font-serif font-bold text-base sm:text-lg text-stone-900 uppercase tracking-wide mb-2">
            @if(request('status') && request('status') !== 'all')
                No {{ ucfirst(request('status')) }} Orders Found
            @else
                No Orders Placed Yet
            @endif
        </h3>
        <p class="text-xs text-stone-500 max-w-md mx-auto mb-5 sm:mb-6 leading-relaxed font-light">
            @if(request('status') && request('status') !== 'all')
                You do not currently have any orders under the "{{ ucfirst(request('status')) }}" status.
            @else
                Explore our curated luxury cosmetics, skincare, and fragrance collections to begin your beauty journey.
            @endif
        </p>
        <div>
            @if(!request('status') || request('status') === 'all')
                <a href="{{ route('product.archive') }}"
                   class="bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest px-7 sm:px-8 py-3 sm:py-3.5 rounded-sm shadow-md hover:shadow-lg transition-all inline-flex items-center gap-2 no-underline">
                    <i class="fa-solid fa-sparkles text-xs"></i>
                    <span>Explore Collection</span>
                </a>
            @else
                <a href="{{ route('profile.edit', ['tab' => 'orders']) }}"
                   class="bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest px-7 sm:px-8 py-3 sm:py-3.5 rounded-sm shadow-md hover:shadow-lg transition-all inline-flex items-center gap-2 no-underline">
                    <span>View All Orders</span>
                </a>
            @endif
        </div>
    </div>
@endforelse