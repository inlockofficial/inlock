<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
         $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        echo "Product ID: " . $product->id; // Debug line
        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'status' => 'pending_payment',
            'expires_at' => now()->addHours(24),
        ]);

        return redirect()->route('orders.payment', $order->id);
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
        ->latest()
        ->with('product')
        ->get();

        return view('dashboard', compact('orders'));
    }

    public function payment(Order $order)
    {
        // security: user can only see their own order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (
            $order->status === 'cancelled' ||
            ($order->expires_at && now()->greaterThan($order->expires_at))
        ) {
            abort(403, 'This order expired due to currency changes.');
        }

        $product = $order->product;

        return view('orders.payment', compact('order', 'product'));
    }

    public function checkout(Request $request, Order $order)
    {
        // security
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'full_name'   => 'required|string|max:255',
            'email'       => 'required|email',
            'phone'       => 'required|string|max:30',
            'address'     => 'required|string|max:1000',
            'city'        => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'notes'       => 'nullable|string|max:1000',
        ]);

        // ✅ Save shipping snapshot into order
        $order->update($validated);

        // ⭐ OPTIONAL — save defaults for autofill
        /*
        $user = Auth::user();

        $user->update([
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);
        */

        // redirect to Chargily payment
        return redirect()->route('chargilypay.redirect', [
            'product_id' => $order->product_id,
            'order_id'   => $order->id,
        ]);
    }

    public function cancel(Order $order)
    {
        // security: owner only
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // allow cancel ONLY when pending_payment
        if ($order->status !== 'pending_payment') {
            return back()->with('error', 'Order cannot be cancelled.');
        }

        $order->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Order cancelled successfully.');
    }
}
