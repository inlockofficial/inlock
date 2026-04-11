<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-semibold">
            Secure Checkout
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">

        <!-- CARD -->
        <div class="bg-[#111827] border border-[#242833] rounded-2xl p-8 shadow-xl">

            <h2 class="text-2xl font-semibold mb-8 text-center">
                Complete Your Order
            </h2>

            <!-- ORDER SUMMARY -->
            <div class="mb-8 p-5 rounded-xl bg-[#0f1115] border border-[#242833]">
                <div class="flex justify-between text-sm text-gray-400">
                    <span>Order</span>
                    <span>#{{ $order->id }}</span>
                </div>

                <div class="mt-3">
                    <p class="text-gray-400 text-sm">Product</p>
                    <p class="text-white leading-relaxed">
                        {{ $product->title }}
                    </p>
                </div>

                <div class="flex justify-between mt-4 text-lg font-semibold">
                    <span>Total</span>
                    <span class="text-[#e9c38c]">
                        {{ number_format($product->final_price_dzd, 2) }} DZD
                    </span>
                </div>

                <div class="mt-4 text-sm text-yellow-300 bg-yellow-500/10 border border-yellow-500/20 p-3 rounded-lg">
                    ⚠️ Order expires
                    <strong>{{ $order->expires_at?->diffForHumans() }}</strong>
                    if not paid.
                </div>
            </div>

            <!-- FORM -->
            <form method="POST"
                  action="{{ route('checkout.process', $order->id) }}"
                  class="space-y-6">
                @csrf

                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <!-- CONTACT -->
                <h3 class="text-lg font-semibold mb-2">Contact Information</h3>

                <div>
                    <x-input-label for="full_name" value="Full Name" />
                    <x-text-input id="full_name"
                        type="text"
                        name="full_name"
                        :value="old('full_name', auth()->user()->name)"
                        required />
                </div>

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email"
                        type="email"
                        name="email"
                        :value="old('email', auth()->user()->email)"
                        required />
                </div>

                <div>
                    <x-input-label for="phone" value="Phone Number" />
                    <x-text-input id="phone"
                        type="text"
                        name="phone"
                        :value="old('phone')"
                        required />
                </div>

                <!-- SHIPPING -->
                <h3 class="text-lg font-semibold pt-4">Shipping Address</h3>

                <div>
                    <x-input-label for="address" value="Address" />
                    <textarea id="address"
                        name="address"
                        rows="3"
                        required
                        class="mt-1 block w-full rounded-md bg-[#0b0f19] border-[#242833] text-white focus:border-[#e9c38c] focus:ring-[#e9c38c]"></textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="city" value="City" />
                        <x-text-input id="city"
                            type="text"
                            name="city"
                            required />
                    </div>

                    <div>
                        <x-input-label for="postal_code" value="Postal Code" />
                        <x-text-input id="postal_code"
                            type="text"
                            name="postal_code" />
                    </div>
                </div>

                <div>
                    <x-input-label for="notes" value="Additional Notes (optional)" />
                    <textarea id="notes"
                        name="notes"
                        rows="2"
                        class="mt-1 block w-full rounded-md bg-[#0b0f19] border-[#242833] text-white focus:border-[#e9c38c] focus:ring-[#e9c38c]"></textarea>
                </div>

                <!-- BUTTON -->
                <x-primary-button class="w-full justify-center text-base py-3">
                    Proceed to Payment
                </x-primary-button>

            </form>

        </div>
    </div>

</x-app-layout>