<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class ChargilyPayController extends Controller
{
    /**
     * The client will be redirected to the ChargilyPay payment page
     *
     */

    public function redirect(Request $request)
    {

    //dd($request->all());

        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = \App\Models\Order::findOrFail($request->order_id);

        $product = $order->product;
        $user = $order->user;

        $rate = 250; // your USD → DZD conversion rate
        $amount = round($product->price_usd * $rate);
        $currency = "dzd";

        $payment = \App\Models\ChargilyPayment::create([
            "user_id"  => $user->id,
            "order_id" => $order->id,
            "status"   => "pending",
            "currency" => $currency,
            "amount"   => $amount,
        ]);
        if ($payment) {
            $checkout = $this->chargilyPayInstance()->checkouts()->create([
                "metadata" => [
                    "payment_id" => $payment->id,
                ],
                "locale" => "ar",
                "amount" => $payment->amount,
                "currency" => $payment->currency,
                "description" => "Payment for {$product->title} (ID={$payment->id})",
                "success_url" => route("chargilypay.back"),
                "failure_url" => route("chargilypay.back"),
                "webhook_endpoint" => "https://4b73-154-255-103-179.ngrok-free.app/chargilypay/webhook",
            ]);

            if ($checkout) {
                return redirect($checkout->getUrl());
            }
       
        }
        return dd("Redirection failed");
        
    }

    /**
     * Your client you will redirected to this link after payment is completed ,failed or canceled
     *
     */

    public function back(Request $request)
    {
        $checkout_id = $request->input("checkout_id");
        $checkout = $this->chargilyPayInstance()->checkouts()->get($checkout_id);

        // Default values if something goes wrong
        $status = 'unknown';
        $amount = null;

        if ($checkout) {
            $status = $checkout->getStatus();       // e.g., "paid", "canceled", "pending"
            $amount = $checkout->getAmount();       // amount paid
        }

        return view('payments.back', [
            'checkout_id' => $checkout_id,
            'status' => $status,
            'amount' => $amount
        ]);
    }

    /**
     * This action will be processed in the background
     */

    public function webhook()
    {
        $webhook = $this->chargilyPayInstance()->webhook()->get();
        if ($webhook) {
            //
            $checkout = $webhook->getData();
            //check webhook data is set
            //check webhook data is a checkout
            if ($checkout and $checkout instanceof \Chargily\ChargilyPay\Elements\CheckoutElement) {
                if ($checkout) {
                    $metadata = $checkout->getMetadata();
                    $payment = \App\Models\ChargilyPayment::find($metadata['payment_id']);

                    if ($payment) {
                        if ($checkout->getStatus() === "paid") {
                            //update payment status in database
                            $payment->status = "paid";
                            $payment->update();
                            /////
                            ///// Confirm your order
                            /////
                            return response()->json(["status" => true, "message" => "Payment has been completed"]);
                        } else if ($checkout->getStatus() === "failed" or $checkout->getStatus() === "canceled") {
                            //update payment status in database
                            $payment->status = "failed";
                            $payment->update();
                            /////
                            /////  Cancel your order
                            /////
                            return response()->json(["status" => true, "message" => "Payment has been canceled"]);
                        }
                    }
                }
            }
        }
        return response()->json([
            "status" => false,
            "message" => "Invalid Webhook request",
        ], 403);
    }

     /**
     * Just a shortcut
     */
    protected function chargilyPayInstance()
    {
        return new \Chargily\ChargilyPay\ChargilyPay(new \Chargily\ChargilyPay\Auth\Credentials([
            "mode" => "test",
            "public" => "test_pk_5aW3zkeA87A5rFOCnULwHunHetVjpXzd3dG3MIkm",
            "secret" => "test_sk_PgmbHW45kqHt0UOrVwP0uJwRJIbw2KxdeY8g6PAd",
        ]));
    }

}
