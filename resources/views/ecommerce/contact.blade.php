@extends('ecommerce.master')

@section('title', 'Contact Us - Harosa Luxury Cosmetics')

@section('main-section')
<div class="bg-stone-50/50 min-h-screen pb-20">

    <!-- 1. Editorial Hero Header -->
    <div class="bg-gradient-to-r from-[#111111] via-[#1c1917] to-[#262013] text-white py-14 sm:py-20 relative overflow-hidden border-b border-[#a28e46]/30">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#a28e46]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="container mx-auto px-4 max-w-7xl relative z-10 text-center">
            <div class="inline-flex items-center gap-2 bg-[#a28e46]/20 border border-[#a28e46]/40 text-[#d4af37] px-4 py-1 text-[11px] font-bold uppercase tracking-widest rounded-full mb-4 shadow-xs">
                <i class="fa-solid fa-headset text-[10px]"></i>
                <span>BEAUTY CONCIERGE & SUPPORT</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white uppercase mb-4">
                GET IN TOUCH WITH US
            </h1>
            <p class="text-stone-300 text-xs sm:text-base font-light max-w-xl mx-auto leading-relaxed">
                Have inquiries regarding an order, skincare advice, or need assistance? Our beauty concierge team is here to assist you.
            </p>
            <nav class="flex items-center justify-center gap-2 text-xs text-stone-400 mt-6" aria-label="Breadcrumb">
                <a href="/" class="hover:text-[#a28e46] transition-colors no-underline text-stone-400">Home</a>
                <span class="text-stone-600">/</span>
                <span class="text-white font-medium">Contact Us</span>
            </nav>
        </div>
    </div>

    <!-- 2. Contact Cards Channels -->
    <div class="container mx-auto px-4 max-w-7xl -mt-8 relative z-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            
            <!-- Phone Support -->
            <div class="bg-white border border-stone-200/90 rounded-sm p-6 text-center shadow-md hover:shadow-xl hover:border-[#a28e46]/50 transition-all duration-300">
                <div class="w-12 h-12 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-lg mx-auto mb-3.5 shadow-xs">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <h3 class="font-serif font-bold text-xs uppercase tracking-wider text-stone-900 mb-1">Call Concierge</h3>
                <p class="text-[11px] text-stone-500 mb-2.5">Direct phone assistance</p>
                @php $phone = $general_settings->contact_phone ?? '+880 1700-000000'; @endphp
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="text-xs font-bold text-[#a28e46] hover:text-[#8e7b39] transition-colors no-underline">
                    {{ $phone }}
                </a>
            </div>

            <!-- Email Support -->
            <div class="bg-white border border-stone-200/90 rounded-sm p-6 text-center shadow-md hover:shadow-xl hover:border-[#a28e46]/50 transition-all duration-300">
                <div class="w-12 h-12 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-lg mx-auto mb-3.5 shadow-xs">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <h3 class="font-serif font-bold text-xs uppercase tracking-wider text-stone-900 mb-1">Email Inquiries</h3>
                <p class="text-[11px] text-stone-500 mb-2.5">Guaranteed response within 24h</p>
                @php $email = $general_settings->contact_email ?? 'support@harosa.com'; @endphp
                <a href="mailto:{{ $email }}" class="text-xs font-bold text-[#a28e46] hover:text-[#8e7b39] transition-colors no-underline truncate block">
                    {{ $email }}
                </a>
            </div>

            <!-- WhatsApp Support -->
            <div class="bg-white border border-stone-200/90 rounded-sm p-6 text-center shadow-md hover:shadow-xl hover:border-[#a28e46]/50 transition-all duration-300">
                <div class="w-12 h-12 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-lg mx-auto mb-3.5 shadow-xs">
                    <i class="fa-brands fa-whatsapp text-xl"></i>
                </div>
                <h3 class="font-serif font-bold text-xs uppercase tracking-wider text-stone-900 mb-1">WhatsApp Chat</h3>
                <p class="text-[11px] text-stone-500 mb-2.5">Instant chat & order tracking</p>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $phone) }}" target="_blank" class="text-xs font-bold text-[#a28e46] hover:text-[#8e7b39] transition-colors no-underline inline-flex items-center gap-1">
                    <span>Chat on WhatsApp</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                </a>
            </div>

            <!-- Location Boutique -->
            <div class="bg-white border border-stone-200/90 rounded-sm p-6 text-center shadow-md hover:shadow-xl hover:border-[#a28e46]/50 transition-all duration-300">
                <div class="w-12 h-12 rounded-full bg-[#faf7f0] text-[#a28e46] flex items-center justify-center text-lg mx-auto mb-3.5 shadow-xs">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h3 class="font-serif font-bold text-xs uppercase tracking-wider text-stone-900 mb-1">Flagship Boutique</h3>
                <p class="text-[11px] text-stone-500 mb-2.5">Visit our store showroom</p>
                <span class="text-xs font-medium text-stone-800 line-clamp-1" title="{{ $general_settings->contact_address ?? 'Dhaka, Bangladesh' }}">
                    {{ $general_settings->contact_address ?? 'Dhaka, Bangladesh' }}
                </span>
            </div>

        </div>
    </div>

    <!-- 3. Main Form & Showroom Hours Section -->
    <div class="container mx-auto px-4 max-w-7xl py-14 sm:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- Left: Contact Form -->
            <div class="lg:col-span-7 bg-white border border-stone-200/80 rounded-sm p-6 sm:p-10 shadow-sm">
                <div class="mb-6">
                    <span class="text-xs font-bold text-[#a28e46] uppercase tracking-widest block mb-1">Send a Message</span>
                    <h2 class="font-serif text-2xl font-bold text-stone-900 uppercase tracking-wide">
                        How Can We Assist You?
                    </h2>
                    <p class="text-stone-500 text-xs mt-1">
                        Fill out the form below and our team will get back to you promptly.
                    </p>
                </div>

                <!-- Alert Feedback -->
                <div id="contactAlertBox" class="hidden mb-5 p-4 rounded-sm text-xs font-medium"></div>

                <form id="contactForm" method="POST" action="{{ route('contact.submit') }}" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                                Full Name <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="full_name" required placeholder="Your full name" class="w-full px-3.5 py-2.5 text-xs bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:outline-none transition-colors">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                                Phone Number <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" name="phone_number" required placeholder="Your phone number" class="w-full px-3.5 py-2.5 text-xs bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:outline-none transition-colors">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                                Email Address
                            </label>
                            <input type="email" name="email" placeholder="you@example.com" class="w-full px-3.5 py-2.5 text-xs bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:outline-none transition-colors">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                                Subject
                            </label>
                            <input type="text" name="subject" placeholder="e.g. Order Inquiry / Skincare advice" class="w-full px-3.5 py-2.5 text-xs bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:outline-none transition-colors">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                            Your Message <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="message" rows="5" required placeholder="Write your message here..." class="w-full px-3.5 py-2.5 text-xs bg-stone-50 border border-stone-300 rounded-sm focus:border-[#a28e46] focus:bg-white focus:outline-none transition-colors resize-none"></textarea>
                    </div>

                    <button type="submit" id="contactSubmitBtn" class="w-full sm:w-auto bg-[#a28e46] hover:bg-[#8e7b39] text-white font-bold text-xs uppercase tracking-widest px-8 py-3.5 rounded-none shadow-md hover:shadow-lg transition-all cursor-pointer focus:outline-none flex items-center justify-center gap-2">
                        <span id="contactSubmitText">Send Message</span>
                        <div id="contactSubmitSpinner" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin hidden"></div>
                    </button>
                </form>
            </div>

            <!-- Right: Store Details & Operating Schedule -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Operating Schedule Card -->
                <div class="bg-white border border-stone-200/80 rounded-sm p-6 sm:p-8 shadow-sm">
                    <h3 class="font-serif font-bold text-sm uppercase tracking-wider text-stone-900 mb-4 pb-3 border-b border-stone-100 flex items-center gap-2">
                        <i class="fa-regular fa-clock text-[#a28e46]"></i>
                        <span>Operating Hours</span>
                    </h3>
                    <ul class="space-y-3 text-xs text-stone-600">
                        <li class="flex justify-between items-center py-1 border-b border-stone-50">
                            <span class="font-medium text-stone-800">Online Store & Support</span>
                            <span class="font-bold text-[#a28e46]">24/7 Everyday</span>
                        </li>
                        <li class="flex justify-between items-center py-1 border-b border-stone-50">
                            <span class="font-medium text-stone-800">Phone & WhatsApp Concierge</span>
                            <span class="font-mono text-stone-700">9:00 AM - 10:00 PM</span>
                        </li>
                        <li class="flex justify-between items-center py-1">
                            <span class="font-medium text-stone-800">Courier Dispatch</span>
                            <span class="font-mono text-stone-700">Sat - Thu (Daily)</span>
                        </li>
                    </ul>
                </div>

                <!-- Showroom & Guarantee Card -->
                <div class="bg-[#faf7f0] border border-[#a28e46]/30 rounded-sm p-6 sm:p-8 shadow-sm">
                    <h3 class="font-serif font-bold text-sm uppercase tracking-wider text-stone-900 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-[#a28e46]"></i>
                        <span>The Harosa Authenticity Guarantee</span>
                    </h3>
                    <p class="text-xs text-stone-600 leading-relaxed mb-4">
                        Every cosmetic, fragrance, and skincare formulation provided by Harosa is 100% genuine, directly imported, and temperature-controlled for peak potency.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-[#a28e46]">
                            <i class="fa-solid fa-truck-fast"></i>
                            <span>Express Shipping</span>
                        </span>
                        <span class="text-stone-300">•</span>
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-[#a28e46]">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>Easy Exchanges</span>
                        </span>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- 4. Quick FAQ Section -->
    <div class="container mx-auto px-4 max-w-4xl pt-4">
        <div class="text-center mb-8">
            <span class="text-xs font-bold text-[#a28e46] uppercase tracking-widest block mb-1">Common Questions</span>
            <h2 class="font-serif text-2xl font-bold text-stone-900 uppercase tracking-wide">
                Frequently Asked Inquiries
            </h2>
        </div>

        <div class="space-y-3">
            <div class="bg-white border border-stone-200/80 rounded-sm p-4 sm:p-5 shadow-xs">
                <h4 class="font-serif font-bold text-xs sm:text-sm text-stone-900 mb-1.5">How long does courier delivery take?</h4>
                <p class="text-xs text-stone-600 leading-relaxed">
                    Inside Dhaka, delivery typically takes 24 to 48 hours. For locations outside Dhaka, deliveries are completed within 2 to 4 business days via our trusted courier partners.
                </p>
            </div>
            <div class="bg-white border border-stone-200/80 rounded-sm p-4 sm:p-5 shadow-xs">
                <h4 class="font-serif font-bold text-xs sm:text-sm text-stone-900 mb-1.5">Are all your products 100% authentic?</h4>
                <p class="text-xs text-stone-600 leading-relaxed">
                    Yes, absolutely. We source exclusively from authorized international brand distributors and verified direct suppliers. Every batch is barcode verified.
                </p>
            </div>
            <div class="bg-white border border-stone-200/80 rounded-sm p-4 sm:p-5 shadow-xs">
                <h4 class="font-serif font-bold text-xs sm:text-sm text-stone-900 mb-1.5">What payment methods do you accept?</h4>
                <p class="text-xs text-stone-600 leading-relaxed">
                    We accept Cash on Delivery (COD), bKash, Nagad, Rocket, as well as Visa, Mastercard, and American Express credit/debit cards.
                </p>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contactForm');
        const submitBtn = document.getElementById('contactSubmitBtn');
        const submitText = document.getElementById('contactSubmitText');
        const spinner = document.getElementById('contactSubmitSpinner');
        const alertBox = document.getElementById('contactAlertBox');

        if (!contactForm) return;

        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            submitBtn.disabled = true;
            submitText.textContent = 'Sending...';
            spinner.classList.remove('hidden');
            alertBox.classList.add('hidden');

            try {
                const formData = new FormData(contactForm);
                const res = await fetch(contactForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await res.json();

                if (data.success) {
                    alertBox.className = 'mb-5 p-4 rounded-sm text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-200';
                    alertBox.textContent = data.message || 'Thank you! Your message has been sent successfully.';
                    alertBox.classList.remove('hidden');
                    contactForm.reset();
                } else {
                    alertBox.className = 'mb-5 p-4 rounded-sm text-xs font-medium bg-rose-50 text-rose-800 border border-rose-200';
                    alertBox.textContent = data.message || 'An error occurred. Please check your inputs and try again.';
                    alertBox.classList.remove('hidden');
                }
            } catch(err) {
                console.error(err);
                alertBox.className = 'mb-5 p-4 rounded-sm text-xs font-medium bg-rose-50 text-rose-800 border border-rose-200';
                alertBox.textContent = 'Could not send your message at this time. Please try calling or WhatsApp.';
                alertBox.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                submitText.textContent = 'Send Message';
                spinner.classList.add('hidden');
            }
        });
    });
</script>
@endpush
@endsection
