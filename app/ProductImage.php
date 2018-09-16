<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['image_url', 'order'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function getSize($width, $height)
    {
        return sprintf('%s?%dx%d', $this->image_url, $width, $height);
    }
}
