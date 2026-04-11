<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INLOCK — Product Details</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-[#0b0f19] text-white min-h-screen flex items-center justify-center p-4 md:p-8">

    <div class="absolute inset-0 opacity-20 blur-3xl pointer-events-none
        bg-[radial-gradient(circle_at_center,#e9c38c_0%,transparent_60%)]">
    </div>

    <div class="
        relative
        bg-[#171a21]
        border border-[#242833]
        rounded-3xl
        shadow-2xl
        p-6 md:p-10
        max-w-4xl
        w-full
        z-10
    ">
        
        <div class="flex justify-between items-center mb-8 border-b border-[#242833] pb-6">
            <div>
                <h1 class="text-2xl font-bold tracking-wide">
                    <span class="text-[#e9c38c]">INLOCK</span>
                </h1>
                <p class="text-gray-400 text-sm">Product Overview</p>
            </div>
            <div class="hidden md:block">
                <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest bg-[#0f1115] border border-[#242833] text-gray-400">
                    ID: #{{ $product->id }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
            
            <div class="md:col-span-5 space-y-6">
                <div class="rounded-2xl overflow-hidden border border-[#242833] bg-[#0f1115] shadow-inner">
                    <img src="{{ asset('storage/'.$product->image) }}" 
                         alt="{{ $product->title }}" 
                         class="w-full h-auto object-contain aspect-square hover:scale-105 transition duration-500" 
                         loading="lazy">
                </div>
                
                @if($product->screenshot)
                <div class="p-4 rounded-xl bg-[#0f1115] border border-[#242833]">
                    <p class="text-[10px] text-gray-500 uppercase tracking-[0.2em] mb-3 font-bold">Reference Screenshot</p>
                    <img src="{{ asset('storage/'.$product->screenshot) }}" 
                         alt="Screenshot" 
                         class="w-full h-auto rounded-lg opacity-80 border border-[#242833]">
                </div>
                @endif
            </div>

            <div class="md:col-span-7 flex flex-col justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-white leading-tight mb-2">
                        {{ $product->title }}
                    </h2>
                    
                    <div class="flex items-baseline gap-2 mb-8">
                        <span class="text-4xl font-black text-[#e9c38c]">
                            {{ number_format($product->final_price_dzd, 2) }}
                        </span>
                        <span class="text-lg font-bold text-[#e9c38c]/70 uppercase">DZD</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="bg-[#0f1115]/50 p-4 rounded-xl border border-[#242833]">
                            <span class="text-[10px] text-gray-500 uppercase font-bold block mb-1">Quantity</span>
                            <span class="text-lg text-gray-100 font-semibold">{{ $product->quantity }}</span>
                        </div>
                        
                        @if($product->color)
                        <div class="bg-[#0f1115]/50 p-4 rounded-xl border border-[#242833]">
                            <span class="text-[10px] text-gray-500 uppercase font-bold block mb-1">Color</span>
                            <span class="text-lg text-gray-100 font-semibold">{{ $product->color }}</span>
                        </div>
                        @endif

                        @if($product->size)
                        <div class="bg-[#0f1115]/50 p-4 rounded-xl border border-[#242833]">
                            <span class="text-[10px] text-gray-500 uppercase font-bold block mb-1">Size</span>
                            <span class="text-lg text-gray-100 font-semibold">{{ $product->size }}</span>
                        </div>
                        @endif
                    </div>

                    @if($product->custom_note)
                    <div class="bg-[#e9c38c]/5 p-4 rounded-xl border border-[#e9c38c]/20 mb-8">
                        <span class="text-[10px] text-[#e9c38c] uppercase font-bold block mb-2">Customer Note</span>
                        <p class="text-gray-300 text-sm leading-relaxed italic">"{{ $product->custom_note }}"</p>
                    </div>
                    @endif
                </div>

                <div class="space-y-4">
                    @if($product->status == 'priced')
                        @auth
                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="w-full py-4 bg-[#e9c38c] hover:bg-[#d4b17a] text-[#0b0f19] text-lg font-black rounded-2xl transition-all duration-300 shadow-xl shadow-[#e9c38c]/10 active:scale-[0.98]">
                                    Buy Product
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block text-center w-full py-4 bg-[#e9c38c] hover:bg-[#d4b17a] text-[#0b0f19] font-black rounded-2xl transition-all">
                                Login to Purchase
                            </a>
                        @endauth
                    @else
                        <button class="w-full py-4 bg-[#242833] text-gray-500 font-bold rounded-2xl cursor-not-allowed border border-dashed border-gray-600" disabled>
                            Review in Progress...
                        </button>
                    @endif

                    <div class="flex gap-4">
                        <a href="{{ route('welcome') }}" class="flex-1 text-center py-3 bg-[#0f1115] hover:bg-[#1c2029] text-gray-400 text-sm font-bold rounded-xl border border-[#242833] transition-all">
                            Back to Store
                        </a>

                        @if($product->status === 'pending_review')
                            <form action="{{ route('cancel.request', $product->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-3 bg-transparent hover:bg-red-500/10 text-red-500/70 hover:text-red-500 text-sm font-bold rounded-xl border border-red-500/10 hover:border-red-500/30 transition-all">
                                    Cancel Request
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>