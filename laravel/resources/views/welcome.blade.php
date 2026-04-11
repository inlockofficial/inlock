<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INLOCK - Shop in Algeria</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#0a0a0a] text-white selection:bg-[#e9c38c] selection:text-black">

    <div class="fixed inset-0 -z-10 pointer-events-none overflow-hidden">
        <div class="absolute top-[-200px] left-1/2 -translate-x-1/2 w-[900px] h-[900px] bg-[#e9c38c]/5 blur-[160px] rounded-full"></div>
    </div>

    <nav x-data="{ mobileMenuOpen: false }" class="fixed w-full z-50 bg-[#0a0a0a]/80 backdrop-blur-md border-b border-[#242833]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-20 items-center">
                <a href="#home" class="flex items-center gap-3 group">
                    <svg class="w-8 h-8 fill-current text-[#e9c38c] transition-transform group-hover:scale-105" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <path d="M50 5 L90 25 L90 75 L50 95 L10 75 L10 25 Z" fill="currentColor"/>
                    </svg>
                    <span class="text-xl font-bold tracking-wider text-white">INLOCK</span>
                </a>

                <ul class="hidden md:flex items-center space-x-8">
                    <li><a href="#home" class="text-sm font-medium text-white hover:text-[#e9c38c] transition-colors">Dashboard</a></li>
                    <li><a href="#featured" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Our Vision</a></li>
                    <li><a href="#faqs" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">FAQs</a></li>
                    <li><a href="#contact" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Contact</a></li>
                </ul>

                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="hidden md:inline-flex items-center px-5 py-2.5 bg-[#e9c38c] text-black text-sm font-semibold rounded-full hover:scale-105 hover:shadow-[0_0_20px_rgba(233,195,140,0.3)] transition-all duration-300">
                        Login
                    </a>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-300 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-[#0f1115] border-b border-[#242833]">
            <ul class="px-6 py-4 space-y-4">
                <li><a @click="mobileMenuOpen = false" href="#home" class="block text-white font-medium">Dashboard</a></li>
                <li><a @click="mobileMenuOpen = false" href="#featured" class="block text-gray-400 hover:text-white">Our Vision</a></li>
                <li><a @click="mobileMenuOpen = false" href="#faqs" class="block text-gray-400 hover:text-white">FAQs</a></li>
                <li><a @click="mobileMenuOpen = false" href="#contact" class="block text-gray-400 hover:text-white">Contact</a></li>
            </ul>
        </div>
    </nav>

    <section id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-12 gap-16 items-center">
            
            <div class="lg:col-span-6 space-y-8">
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-[#e9c38c]/10 border border-[#e9c38c]/20 text-[#e9c38c] text-xs font-medium uppercase tracking-wide">
                    New Collection 2025
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-semibold leading-tight">
                    Made for <br>
                    <span class="text-[#e9c38c]">Algerian</span> <br>
                    Shoppers
                </h1>
                
                <p class="text-lg text-gray-400 max-w-lg leading-relaxed">
                    Paste your AliExpress link, pay in DZD. Inlock makes cross-border online shopping simple, secure, and accessible.
                </p>

                <div class="flex gap-8 pt-4 border-t border-[#242833]/50">
                    <div>
                        <div class="text-2xl font-bold text-white">1000+</div>
                        <div class="text-sm text-gray-500 mt-1">Products Ordered</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">0%</div>
                        <div class="text-sm text-gray-500 mt-1">Hidden Fees</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">100%</div>
                        <div class="text-sm text-gray-500 mt-1">Secure</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6">
                <div class="bg-[#171a21] border border-[#242833] rounded-2xl p-8 shadow-2xl relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-[#e9c38c]/20 to-transparent blur-xl -z-10 rounded-2xl opacity-50"></div>

                    <h3 class="text-xl font-medium mb-6 text-white">Request a Price Estimate</h3>

                    @if ($errors->any())
                        <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg mb-6 text-sm">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('request.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">AliExpress Product Link <span class="text-[#e9c38c]">*</span></label>
                            <input type="url" name="ali_link" placeholder="https://aliexpress.com/item/..." required
                                class="w-full bg-[#0f1115] border border-[#242833] rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-[#e9c38c] focus:ring-1 focus:ring-[#e9c38c] transition-all outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Color <span class="text-gray-500 text-xs font-normal">(Optional)</span></label>
                                <select name="color" class="w-full bg-[#0f1115] border border-[#242833] rounded-xl px-4 py-3 text-white focus:border-[#e9c38c] focus:ring-1 focus:ring-[#e9c38c] transition-all outline-none appearance-none">
                                    <option value="">Select color</option>
                                    <option>Black</option>
                                    <option>White</option>
                                    <option>Blue</option>
                                    <option>Red</option>
                                    <option>Green</option>
                                    <option>Pink</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Size <span class="text-gray-500 text-xs font-normal">(Optional)</span></label>
                                <select name="size" class="w-full bg-[#0f1115] border border-[#242833] rounded-xl px-4 py-3 text-white focus:border-[#e9c38c] focus:ring-1 focus:ring-[#e9c38c] transition-all outline-none appearance-none">
                                    <option value="">Select size</option>
                                    <option>XS</option><option>S</option><option>M</option>
                                    <option>L</option><option>XL</option><option>XXL</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Quantity <span class="text-[#e9c38c]">*</span></label>
                                <input type="number" name="quantity" min="1" value="1" required
                                    class="w-full bg-[#0f1115] border border-[#242833] rounded-xl px-4 py-3 text-white focus:border-[#e9c38c] focus:ring-1 focus:ring-[#e9c38c] transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Gender <span class="text-gray-500 text-xs font-normal">(Optional)</span></label>
                                <select name="gender" class="w-full bg-[#0f1115] border border-[#242833] rounded-xl px-4 py-3 text-white focus:border-[#e9c38c] focus:ring-1 focus:ring-[#e9c38c] transition-all outline-none appearance-none">
                                    <option value="">Not specified</option>
                                    <option value="male">Men</option>
                                    <option value="female">Women</option>
                                    <option value="unisex">Unisex</option>
                                    <option value="kids">Kids</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Add Screenshot <span class="text-gray-500 text-xs font-normal">(Optional)</span></label>
                            <input type="file" name="screenshot" accept="image/*"
                                class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#242833] file:text-white hover:file:bg-[#2a2f3a] transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Extra Details</label>
                            <textarea name="custom_note" rows="2" placeholder="Example: size XXL, dark blue color, cotton version..."
                                class="w-full bg-[#0f1115] border border-[#242833] rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-[#e9c38c] focus:ring-1 focus:ring-[#e9c38c] transition-all outline-none resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-[#e9c38c] text-black font-semibold rounded-xl hover:bg-[#d6b07a] transition-colors mt-2">
                            Request DZD Price
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section id="featured" class="py-20 border-t border-[#242833]/50 bg-[#0a0a0a]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-[#e9c38c] font-medium text-sm tracking-widest uppercase">Built for the Future</span>
                <h2 class="text-3xl md:text-5xl font-semibold mt-4 mb-6">Shop Smart, Live Better.</h2>
                <p class="text-gray-400 text-lg">
                    Inlock is built with one goal: to make cross-border shopping simple, accessible, and stress-free. We eliminate payment barriers by offering smooth local payment options and real-time DZD conversion.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-[#0f1115] border border-[#242833] rounded-2xl p-8 hover:border-[#e9c38c]/50 transition-colors group">
                    <div class="w-12 h-12 bg-[#171a21] rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">👛</span>
                    </div>
                    <h3 class="text-xl font-medium text-white mb-3">Local Payments</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Pay directly in DZD using familiar local methods like EDAHABIA. No international bank card required.</p>
                </div>
                <div class="bg-[#0f1115] border border-[#242833] rounded-2xl p-8 hover:border-[#e9c38c]/50 transition-colors group">
                    <div class="w-12 h-12 bg-[#171a21] rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">💱</span>
                    </div>
                    <h3 class="text-xl font-medium text-white mb-3">Instant Conversion</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">See every product automatically converted into DZD with transparent, real-time calculations.</p>
                </div>
                <div class="bg-[#0f1115] border border-[#242833] rounded-2xl p-8 hover:border-[#e9c38c]/50 transition-colors group">
                    <div class="w-12 h-12 bg-[#171a21] rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">📦</span>
                    </div>
                    <h3 class="text-xl font-medium text-white mb-3">Simplified Ordering</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Place your order in a few taps. Inlock handles the international checkout and payment behind the scenes.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="faqs" class="py-20 border-t border-[#242833]/50">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-semibold mb-4">Everything You Need To Know</h2>
                <p class="text-gray-400">Common questions about using InLock.</p>
            </div>

            <div class="space-y-4" x-data="{ selected: 1 }">
                <div class="bg-[#0f1115] border border-[#242833] rounded-xl overflow-hidden">
                    <button @click="selected !== 1 ? selected = 1 : selected = null" class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-medium text-white">What is InLock?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="{ 'rotate-180': selected === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="selected === 1" x-collapse>
                        <div class="px-6 pb-5 text-gray-400 text-sm">
                            InLock is a platform that simplifies online shopping by enabling secure local payment options (currently EDAHABIA card in Algeria) for international purchases.
                        </div>
                    </div>
                </div>

                <div class="bg-[#0f1115] border border-[#242833] rounded-xl overflow-hidden">
                    <button @click="selected !== 2 ? selected = 2 : selected = null" class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-medium text-white">How does it work?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="{ 'rotate-180': selected === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="selected === 2" x-collapse>
                        <div class="px-6 pb-5 text-gray-400 text-sm">
                            Simply copy an AliExpress link, paste it in our dashboard to get the DZD price, and choose your preferred local payment method to checkout seamlessly.
                        </div>
                    </div>
                </div>

                <div class="bg-[#0f1115] border border-[#242833] rounded-xl overflow-hidden">
                    <button @click="selected !== 3 ? selected = 3 : selected = null" class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-medium text-white">Why should I use local payment options?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="{ 'rotate-180': selected === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="selected === 3" x-collapse>
                        <div class="px-6 pb-5 text-gray-400 text-sm">
                            Local payments are faster, safer, and save you from black-market exchange rates and international transaction fees.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="py-20 border-t border-[#242833]/50 bg-[#0a0a0a]">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16">
            <div>
                <h2 class="text-3xl md:text-4xl font-semibold mb-4">Join InLock Early Access</h2>
                <p class="text-gray-400 mb-10">We're currently in pre-launch. Reach out to secure your spot or ask us anything.</p>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-[#171a21] border border-[#242833] flex items-center justify-center flex-shrink-0">
                            <span>🌐</span>
                        </div>
                        <div>
                            <h4 class="text-white font-medium">Platform Status</h4>
                            <p class="text-sm text-gray-400 mt-1">Beta (Pre-launch). Access opening soon.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-[#171a21] border border-[#242833] flex items-center justify-center flex-shrink-0">
                            <span>📩</span>
                        </div>
                        <div>
                            <h4 class="text-white font-medium">Email Support</h4>
                            <p class="text-sm text-gray-400 mt-1"><a href="mailto:inlockofficial@gmail.com" class="hover:text-[#e9c38c] transition-colors">inlockofficial@gmail.com</a></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-[#171a21] border border-[#242833] flex items-center justify-center flex-shrink-0">
                            <span>📱</span>
                        </div>
                        <div>
                            <h4 class="text-white font-medium">Instagram</h4>
                            <p class="text-sm text-gray-400 mt-1"><a href="https://www.instagram.com/inlock_dz_gold/" target="_blank" rel="noopener noreferrer" class="hover:text-[#e9c38c] transition-colors">@inlock_dz_gold</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[#0f1115] border border-[#242833] rounded-2xl p-8">
                <form id="contactForm" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
                        <input type="email" id="email" name="email" placeholder="john@example.com" required
                            class="w-full bg-[#171a21] border border-[#242833] rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-[#e9c38c] focus:ring-1 focus:ring-[#e9c38c] transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="How can we help?" required
                            class="w-full bg-[#171a21] border border-[#242833] rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-[#e9c38c] focus:ring-1 focus:ring-[#e9c38c] transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Message</label>
                        <textarea id="message" name="message" rows="4" placeholder="Tell us more about your inquiry..." required
                            class="w-full bg-[#171a21] border border-[#242833] rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-[#e9c38c] focus:ring-1 focus:ring-[#e9c38c] transition-all outline-none resize-none"></textarea>
                    </div>
                    <button type="button" class="w-full py-3.5 bg-white text-black font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </section>

    <footer class="border-t border-[#242833] bg-[#0a0a0a] pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-2 md:col-span-1">
                    <h3 class="text-xl font-bold tracking-wider text-white mb-4">INLOCK</h3>
                    <p class="text-sm text-gray-400 leading-relaxed pr-4">
                        Empowering Algerians with accessible digital solutions and smart cross-border shopping tools.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-medium mb-4">Platform</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#home" class="hover:text-[#e9c38c] transition">Dashboard</a></li>
                        <li><a href="#featured" class="hover:text-[#e9c38c] transition">Features</a></li>
                        <li><a href="#faqs" class="hover:text-[#e9c38c] transition">FAQs</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-medium mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#contact" class="hover:text-[#e9c38c] transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-[#e9c38c] transition">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-[#e9c38c] transition">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <h4 class="text-white font-medium mb-4">Accepted Payments</h4>
                    <div class="flex gap-2">
                        <div class="px-3 py-1.5 border border-[#242833] rounded text-xs text-gray-400 bg-[#0f1115]">EDAHABIA</div>
                        <div class="px-3 py-1.5 border border-[#242833] rounded text-xs text-gray-400 bg-[#0f1115]">CIB</div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-[#242833] pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} INLOCK. All rights reserved.
                </p>
                <p class="text-sm text-gray-500">
                    Designed by <a href="https://www.instagram.com/kaza_hikari/" target="_blank" rel="nofollow" class="text-[#e9c38c] hover:underline">Hikari</a>
                </p>
            </div>
        </div>
    </footer>

</body>
</html>