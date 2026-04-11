<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function process(Request $request, Order $order)
    {
        // security check
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // validate shipping form
        $validated = $request->validate([
            'full_name'   => 'required|string|max:255',
            'email'       => 'required|email',
            'phone'       => 'required|string|max:30',
            'address'     => 'required|string|max:1000',
            'city'        => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'notes'       => 'nullable|string|max:1000',
        ]);

        // save shipping snapshot
        $order->update($validated);

        // return view with auto-submitting form
        return view('payments.redirect_to_chargily', [
            'order_id' => $order->id
        ]);
    }
}
