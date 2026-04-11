<?php

namespace App\Services;

class AliExpressExtractor
{
    public function fetchProduct(string $url)
    {
        // Fake browser headers (VERY IMPORTANT)
        $context = stream_context_create([
            "http" => [
                "header" =>
                    "User-Agent: Mozilla/5.0\r\n" .
                    "Accept-Language: en-US,en;q=0.9\r\n"
            ]
        ]);

        $html = @file_get_contents($url, false, $context);

        if (!$html) {
            return null;
        }

        // Extract hidden JSON used by AliExpress React app
        preg_match(
            '/__NEXT_DATA__"\s*type="application\/json">(.*?)<\/script>/s',
            $html,
            $matches
        );

        if (!isset($matches[1])) {
            return null;
        }

        $json = json_decode($matches[1], true);

        return $this->extractProductData($json);
    }

    private function extractProductData($json)
    {
        try {

            $data =
                $json['props']['pageProps']['initialData']['data']
                ?? null;

            if (!$data) {
                return null;
            }

            $title = $data['titleModule']['subject'] ?? null;

            $priceString =
                $data['priceModule']['formatedActivityPrice']
                ?? $data['priceModule']['formatedPrice']
                ?? null;

            return [
                'title' => $title,
                'price_usd' => $this->cleanPrice($priceString)
            ];

        } catch (\Exception $e) {
            return null;
        }
    }

    private function cleanPrice($price)
    {
        if (!$price) return null;

        return floatval(
            preg_replace('/[^0-9.]/', '', $price)
        );
    }
}