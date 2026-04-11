<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white">
            My Orders 🛒
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Container -->
            <div class="bg-[#171a21] border border-[#242833] rounded-2xl p-6 shadow-xl">

                <h3 class="text-lg font-semibold mb-6 text-gray-200">
                    Your Orders
                </h3>

                @forelse($orders as $order)

                    @php
                        $product = $order->product;

                        // Status colors
                        $statusColors = [
                            'pending' => 'bg-yellow-500/20 text-yellow-400',
                            'pending_review' => 'bg-yellow-500/20 text-yellow-400',
                            'priced' => 'bg-blue-500/20 text-blue-400',
                            'paid' => 'bg-green-500/20 text-green-400',
                            'shipped' => 'bg-purple-500/20 text-purple-400',
                            'cancelled' => 'bg-red-500/20 text-red-400',
                        ];

                        $badge = $statusColors[$order->status] ?? 'bg-gray-500/20 text-gray-400';
                    @endphp

                    <!-- ORDER CARD -->
                    <div class="
                        bg-[#0f1115]
                        border border-[#242833]
                        rounded-xl
                        p-5 mb-5
                        flex flex-col md:flex-row
                        gap-6
                        hover:border-[#e9c38c]/40
                        transition
                    ">

                        <!-- Product Image -->
                        <div class="flex-shrink-0">
                            @if($product && $product->image)
                                <img
                                    src="{{ asset('storage/'.$product->image) }}"
                                    class="w-28 h-28 object-cover rounded-lg border border-[#242833]"
                                    loading="lazy">
                            @else
                                <div class="w-28 h-28 bg-[#171a21] rounded-lg flex items-center justify-center text-gray-500 text-sm">
                                    No Image
                                </div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="flex-1">

                            <h4 class="text-lg font-semibold text-white mb-2">
                                {{ $product->title ?? 'Product unavailable' }}
                            </h4>

                            <!-- Status -->
                            <span class="px-3 py-1 text-xs rounded-full {{ $badge }}">
                                {{ ucfirst(str_replace('_',' ', $order->status)) }}
                            </span>

                            <!-- Details -->
                            <div class="mt-4 text-sm text-gray-400 space-y-1">

                                <p>
                                    <span class="text-gray-500">Order ID:</span>
                                    #{{ $order->id }}
                                </p>

                                @if($product)
                                    <p>
                                        <span class="text-gray-500">Price:</span>
                                        <span class="text-[#e9c38c] font-semibold">
                                            {{ number_format($product->final_price_dzd ?? 0, 2) }} DZD
                                        </span>
                                    </p>
                                @endif

                                @if($order->status === 'pending_payment')
                                    <p class="text-yellow-400 text-sm">
                                        Pay before {{ $order->expires_at->diffForHumans() }}
                                    </p>
                                @endif

                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col gap-2 justify-center">

                        <!-- View Order -->

                            @if($order->status === 'pending_payment')
                                <a href="{{ route('orders.payment', $order->id) }}"
                                class="px-5 py-2 bg-[#e9c38c] text-black text-sm font-semibold rounded-lg hover:scale-105 transition text-center">
                                    View Order →
                                </a>
                                <form method="POST"
                                    action="{{ route('orders.cancel', $order->id) }}"
                                    onsubmit="return confirm('Cancel this order?')">
                                    @csrf

                                    <button type="submit"
                                        class="w-full px-5 py-2 text-sm font-semibold rounded-lg
                                            border border-red-500/40 text-red-400
                                            hover:bg-red-500/10 transition">
                                        Cancel Order
                                    </button>
                                </form>
                            @endif

                        </div>

                    </div>

                @empty

                    <!-- Empty State -->
                    <div class="text-center py-16">

                        <p class="text-gray-400 mb-4">
                            You haven't placed any orders yet.
                        </p>

                        <a href="{{ route('welcome') }}"
                           class="px-6 py-3 bg-[#e9c38c] text-black rounded-lg font-semibold hover:scale-105 transition">
                            Start Shopping
                        </a>

                    </div>

                @endforelse

            </div>

        </div>
    </div>

</x-app-layout>