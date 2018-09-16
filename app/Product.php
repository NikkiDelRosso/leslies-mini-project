<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
}
