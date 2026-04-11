<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            My Orders
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-xl font-bold mb-4">Your Orders</h3>

                @forelse($orders as $order)
                    <div class="border rounded-lg p-4 mb-4">
                        <p><strong>Product:</strong> {{ $order->product_name }}</p>
                        <p><strong>Status:</strong> {{ $order->status }}</p>
                        <p><strong>Price:</strong> {{ $order->price }} DZD</p>
                    </div>
                @empty
                    <p>No orders yet.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>