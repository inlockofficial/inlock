<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
require '../vendor/autoload.php';

use App\Services\AliExpressService;

class LinkController extends Controller
{
    public function process(Request $request){

        $request->validate([
            'url' => [
                'required', 
                'url', 
                'regex:/aliexpress\.com/i'
            ],
        ]);

        $url = $request->input('url');
        $apiToken = env('APIFY_API_TOKEN');
        $cleanUrl = strtok($url, '?');

       $response = Http::withToken($apiToken)
            ->post("https://api.apify.com/v2/acts/saswave~aliexpress-scraper/run-sync-get-dataset-items?timeout=60", [
                "startUrls" => [
                    ["url" => $cleanUrl]
                ],
                "maxItems" => 1,
            ]);

        if ($response->successful()) {
            // The dataset items endpoint returns an array directly
            $items = $response->json();
            $product = $items[0] ?? null;

            if ($product) {
                return view('product-result', [
                    'title' => $product['title'] ?? 'Product Found',
                    'image' => $product['image'] ?? ($product['imageUrl'] ?? ''),
                    'price' => $product['price'] ?? 0,
                    'link'  => $cleanUrl
                ]);
            }
        }

        // If it fails, log the error for debugging
        \Log::error("Apify Error: " . $response->body());
        
        return back()->withErrors(['url' => 'Could not extract product info. Check your API Token or Link.']);
    }
/*
    public function test(Request $request) {
    // 1. Tell PHP to allow this script to run for up to 3 minutes
    // This overrides the 'max_execution_time' in php.ini just for this request.
    set_time_limit(180); 

    $client = new \GuzzleHttp\Client([
        'base_uri' => 'https://api.apify.com/v2/',
        'headers' => [
            'Authorization' => 'Bearer ' . env('APIFY_API_TOKEN'),
        ],
        // 2. Tell Guzzle not to give up on the connection
        'timeout'         => 180, 
        'connect_timeout' => 30,
    ]); 

    $url = $request->input('url');
    $cleanUrl = strtok($url, '?');

    try {
        $response = $client->post('acts/pintostudio~aliexpress-product-description/run-sync-get-dataset-items', [
            'query' => [ 
                'timeout' => 120 // Tell Apify to wait up to 120s for the scraper
            ],
            'json' => [
                'productUrl' => $cleanUrl,
            ],
        ]);

        $items = \json_decode($response->getBody(), true);
        //return response()->json($items);

        $product = $items[0]['data'] ?? null; // The JSON has a 'data' wrapper inside the first item

if ($product) {
    // Extract numeric price (e.g., 0.99)
    $numericPrice = $product['prices']['targetSkuPriceInfo']['originalPrice']['value'] ?? 0;
    
    return view('product-result', [
        'title' => $product['title'],
        'image' => $product['image'],
        'price' => $numericPrice,
        'link'  => $product['url']
    ]);
}

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'The request took too long or failed.',
            'details' => $e->getMessage()
        ], 500);
    }
}
    */
    public function test(Request $request) {
    // 1. Tell PHP to allow this script to run for up to 3 minutes
    // This overrides the 'max_execution_time' in php.ini just for this request.
    set_time_limit(180); 

    $client = new \GuzzleHttp\Client([
        'base_uri' => 'https://api.apify.com/v2/',
        'headers' => [
            'Authorization' => 'Bearer ' . env('APIFY_API_TOKEN'),
        ],
        // 2. Tell Guzzle not to give up on the connection
        'timeout'         => 180, 
        'connect_timeout' => 30,
    ]); 

    $url = $request->input('url');
    $cleanUrl = strtok($url, '?');

    try {
        $response = $client->post('acts/pintostudio~aliexpress-product-description/run-sync-get-dataset-items', [
            'query' => [ 
                'timeout' => 120 // Tell Apify to wait up to 120s for the scraper
            ],
            'json' => [
                'productUrl' => $cleanUrl,
            ],
        ]);


$items = \json_decode($response->getBody(), true);
$product = $items[0]['data'] ?? null;

if ($product) {
    // --- 1. Calculate Average Product Price ---
    // We look at all SKU combinations to find the middle ground
    $skuPrices = collect($product['skuIdPrices'] ?? [])->pluck('salePriceLocal');
    
    // Clean strings like "US $0.99" into numbers
    $numericPrices = $skuPrices->map(function($price) {
        return (float) filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    })->filter();

    $averagePrice = $numericPrices->avg() ?: 0;
    
    // --- 2. Find the Cheapest Shipping Option ---
    $shippingOptions = collect($product['shipping'] ?? []);
    $cheapestShipping = $shippingOptions->min('price.displayAmount') ?? 0;

    // --- 3. Final Math ---
    $totalUsd = $averagePrice + $cheapestShipping;

    // if the user is logged in, save the product to the DB
    if(auth()->check()) {
        auth()->user()->products()->create([
            'title'        => $product['title'],
            'image'        => $product['image'],
            'price_usd'    => $averagePrice,
            'shipping_usd' => $cheapestShipping,
            'ali_link'     => $cleanUrl,
        ]);
    }

    return view('product-result', [
        'title'         => $product['title'],
        'image'         => $product['image'],
        'averagePrice'  => $averagePrice,
        'shippingPrice' => $cheapestShipping,
        'totalUsd'      => $totalUsd,
        'link'          => $product['url']
    ]);
}

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'The request took too long or failed.',
            'details' => $e->getMessage()
        ], 500);
    }
}
/*
public function handleSearch(Request $request, AliExpressService $aliService) 
{
    $productId = $this->extractId($request->url); // Create a helper to get ID from URL
    $data = $aliService->getProductDetails($productId);

    // Save to DB and Show View
    return view('product-result', ['product' => $data['resp_result']['result']]);
}
*/
public function handleSearch(Request $request, AliExpressService $aliService) 
{
    $productId = $this->extractId($request->url);
    
    if (!$productId) {
        return back()->with('error', 'Invalid AliExpress URL');
    }
    //dd($productId);
    // Call the real API
    $result = $aliService->getProductDetails($productId);

    // This stops the code and shows the raw data from AliExpress on your screen
    dd($result); 
}

private function extractId($url)
{
    // Regex to find the 10 to 15 digit product ID in an AliExpress URL
    if (preg_match('/\/item\/(\d+)\.html/', $url, $matches)) {
        return $matches[1];
    }
    
    // Fallback for short links or different formats
    if (preg_match('/(\d{10,})/', $url, $matches)) {
        return $matches[1];
    }

    return null;
}

}