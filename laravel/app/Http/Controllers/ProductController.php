<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ali_link' => 'required|url',
            'screenshot' => 'nullable|image|max:2048'
        ]);

        $url = $request->ali_link;
        $cleanUrl = strtok($url, '?');

        $screenshotPath = null;

        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')
                ->store('screenshots', 'public');
        }

        $product = Product::create([
            'ali_link' => $cleanUrl,
            'user_id' => auth()->id(),
            'color' => $request->color,
            'size' => $request->size,
            'quantity' => $request->quantity,
            'gender' => $request->gender,
            'custom_note' => $request->custom_note,
            'screenshot' => $screenshotPath,
        ]);

        return redirect()->route('request.waiting', $product->id);
    }

    public function adminIndex() {
        $requests = Product::orderBy('created_at', 'desc')->get();
        return view('admin.requests', compact('requests'));
    }

    public function adminShow($id) {
        $request = Product::findOrFail($id);
        return view('admin.request-show', compact('request'));
    }

    public function adminUpdate(Request $request, $id) {
        //dd("ADMIN UPDATE HIT");
        $product = Product::findOrFail($id);
        //dd($product);
        $imageUrl = $request->image;

        /*
        | Fix AliExpress AVIF images
        | Keep only real JPG part
        */
        if (str_contains($imageUrl, '.jpg')) {
            $imageUrl = substr($imageUrl, 0, strpos($imageUrl, '.jpg') + 4);
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|file|mimes:jpg,jpeg,png,webp,avif|max:2048',
            'price_usd' => 'required|numeric|min:0',
            'shipping_usd' => 'nullable|numeric|min:0',
            'service_margin' => 'nullable|numeric|min:0',
        ]);

        $rate = config('app.usd_to_dzd');
        $rawPrice = ($request->price_usd + $request->shipping_usd) * $rate;
        if ($request->service_margin) {
            $rawPrice += $request->service_margin; // make it in %
        }
        $finalDzd = ceil($rawPrice / 100) * 100;

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('products', 'public');
        }         

        $product->update([
            'title' => $request->title,
            'image' => $imagePath,
            'price_usd' => $request->price_usd,
            'shipping_usd' => $request->shipping_usd ?? 0,
            'final_price_dzd' => $finalDzd,
            'rate_used' => $rate,
            'status' => 'priced',
        ]);
        //dd($request->all());

        return redirect()->route('admin.requests')->with('success', 'Product updated!');
    }
}
