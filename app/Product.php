<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function getThumbnail($height = 200, $width = 200)
    {
        if (!$this->thumbnail) {
            return null;
        }

        return $this->thumbnail->getSize($height, $width);
    }

    private function _addToMatches(&$collection, $products)
    {
        foreach($products as $product) {
            $existing = $collection->get($product->id);
            if ($existing) {
                $existing->relevance += 1;
            } else {
                $existing = (object)[
                    'product' => $product,
                    'relevance' => 1
                ];
            }

            $collection->put($product->id, $existing);
        }

        return $collection;
    }

    public function getRelatedProducts()
    {
        $matches = collect([]);
        $fields = ['brand', 'type'];

        foreach ($fields as $field) {
            $products = self::where('id', '!=', $this->id)->with('thumbnail')->where($field, $this->{$field})->get();
            $this->_addToMatches($matches, $products);
        }

        foreach ($this->atts as $attr) {
            $products = self::where('id', '!=', $this->id)->with('thumbnail')->whereHas('atts', function($query) use ($attr) {
                $query->where('key', $attr->key)->where('value', $attr->value);
            })->get();
            $this->_addToMatches($matches, $products);
        }

        return $matches->sortByDesc('relevance')->values()->all();
    }
}
