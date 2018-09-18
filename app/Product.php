<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Product extends Model
{
    protected $visible = ['id', 'name', 'brand', 'type', 'thumbnail', 'atts', 'images'];

    public function atts()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function thumbnail()
    {
        return $this->belongsTo(ProductImage::class);
    }

    public function getRelatedProducts()
    {
        $one_week = 60*24*7;
        $key = 'related_products_for_' . $this->id;

        return Cache::remember($key, $one_week, function() {
            $matches = collect([]);

            // We could customize the weight of the base attributes here
            $fields = [
                'brand' => 1,
                'type' => 1
            ];

            foreach ($fields as $field => $weight) {
                $query = Product::where($field, $this->{$field});
                $this->_addToMatches($matches, $query, $weight);
            }

            foreach ($this->atts as $attr) {
                $query = Product::whereHas('atts', function($query) use ($attr) {
                    $query->where('key', $attr->key)->where('value', $attr->value);
                });
                $this->_addToMatches($matches, $query);
            }

            return $matches->sortByDesc('relevance')->values();
        });
    }

    // This is a helper for the getRelatedProducts method
    private function _addToMatches(&$matches, $query, $weight = 1)
    {
        $products = $query->where('id', '!=', $this->id)->with('thumbnail')->get();

        foreach($products as $product) {
            $existing = $matches->get($product->id);
            if ($existing) {
                $existing->relevance += $weight;
            } else {
                $existing = (object)[
                    'product' => $product,
                    'relevance' => $weight
                ];
            }

            $matches->put($product->id, $existing);
        }

        return $matches;
    }

    public function loadDetails()
    {
        return $this->load(['atts', 'images' => function($query) {
                $query->ordered();
            }])->makeVisible('description');
    }
}
