<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AliExpressExtractor;

class ExtractorController extends Controller
{
    public function fetch(Request $request, AliExpressExtractor $service)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $product = $service->fetchProduct($request->url);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product extraction failed'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }
}
