<?php

namespace App\Leslies;

use GuzzleHttp\Client;
use Cache;

class LesliesApiWrapper
{
    private $api_key, $api_url, $cache_timeout, $client;

    public function __construct()
    {
        $this->api_key = config('services.leslies.api_key');
        $this->api_url = config('services.leslies.api_url');
        $this->cache_timeout = config('services.leslies.cache_timeout');
        $this->client = new Client([
            'headers' => [
                'authkey' => $this->api_key
            ]
        ]);
    }

    public function get($params = [])
    {
        $url = $this->api_url;
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        $response = $this->client->request('GET', $url);
        return json_decode($response->getBody());
    }

    public function listProducts()
    {
        return Cache::remember('leslies_api_listProducts', 60, function() {
            return $this->get();
        });
    }

    public function getProduct($id)
    {
        return Cache::remember(sprintf('leslies_api_getProduct[%s]', $id), 60, function() use($id) {
            return $this->get(['productid' => $id]);
        });
    }
}