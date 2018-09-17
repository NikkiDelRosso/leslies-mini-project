<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['image_url', 'order'],
        $visible = ['image_url'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Not using this from the Laravel side, but I can get thumbnails like so
    // public function getSize($width, $height)
    // {
    //     return sprintf('%s?%dx%d', $this->image_url, $width, $height);
    // }
}
