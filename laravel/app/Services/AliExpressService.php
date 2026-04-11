<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AliExpressService
{
    protected $appKey;
    protected $appSecret;
    protected $trackingId;
    protected $baseUrl = 'https://api-sg.aliexpress.com/router/rest'; 
//https://gw.api.alibaba.com/openapi/param2/2/portals.open/                    // first url i was using, gemini said it's old
//https://api-sg.aliexpress.com/router/rest                                    // at last gemini suggested this url (more stable)
//https://api-sg.aliexpress.com/sync                                           // second one suggested (passing by Singapore gateway)

    public function __construct()
    {
        // i'm fetching these 3 codes needed for the API from config file that connects to my .env
        $this->appKey = config('services.aliexpress.key');
        $this->appSecret = config('services.aliexpress.secret');
        $this->trackingId = config('services.aliexpress.tracking_id');
    }

    public function getProductDetails($productId)
    {

        $params = [
            'app_key' => $this->appKey,
            'timestamp' => gmdate('Y-m-d H:i:s'),
            //'timestamp' => now('Asia/Shanghai')->format('Y-m-d H:i:s'), // changing the timezone in the request
            //'timestamp' => (string) now()->getPreciseTimestamp(3),
            'method' => 'aliexpress.affiliate.product.detail.get',
            // more params required for the new base url:
            'format'       => 'json',          // New: Explicitly ask for JSON
            'v'            => '2.0',           // New: Protocol version
            'sign_method'  => 'md5',           // New: This fixes your current error
            'product_id' => $productId,
            'target_currency' => 'USD',
            'target_language' => 'EN',
            'ship_to_country' => 'DZ',
            'tracking_id' => $this->trackingId,
            'fields' => 'product_id,product_main_image_url,product_title,
                        target_sale_price,target_original_price,
                        evaluate_rate,lastest_volume',
        ];

        $params['sign'] = $this->generateSignature($params); // every request must have a signature (view next function)
        logger()->info('AliExpress Request:', $params); // i'm loggin the request to check what params are passed
        $response = Http::timeout(30) // Wait up to 30 seconds
    ->connectTimeout(15)      // Wait 15 seconds just to connect and find the AliExpress server
    ->withOptions([
        'force_ip_resolve' => 'v4', // FORCES IPv4 (Essential for DZ networks, iykyk)
    ])
    ->withoutVerifying()
    ->get($this->baseUrl, $params);
// . 'api.aliexpress.affiliate.product.item.get/' . $this->appKey                      // first url needed this extension but the new ones only use params
        return $response->json(); // i'm returning the json to see the data returned
    }

    // generating signature for each request (written by gemini)
    private function generateSignature($params)
    {
        ksort($params);
        $stringToBeSigned = $this->appSecret;
        foreach ($params as $k => $v) {
            $stringToBeSigned .= $k . $v;
        }
        $stringToBeSigned .= $this->appSecret;
        return strtoupper(md5($stringToBeSigned));
    }
}