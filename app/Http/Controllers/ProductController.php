<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
        /* The list of products for this project is small. In a real application, we would probably want to paginate or 
           limit in some way. */
        
        $products = Product::orderBy('name', 'asc')
            ->with('thumbnail:id,image_url')
            ->select(['id', 'thumbnail_id', 'name', 'brand', 'type'])
            ->get();

        return response()->json(['products' => $products]);
    }

    public function show(Product $product)
    {
        $product->load(['attributes', 'images' => function($query) {
            $query->ordered();
        }]);
        return response()->json($product);
    }
}
