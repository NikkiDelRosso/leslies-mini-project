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
            ->with('thumbnail')
            ->get();

        return response()->json(['products' => $products]);
    }

    public function show(Product $product)
    {
        return response()->json([
            'product' => $product->loadDetails(),
            'related_products' => $product->getRelatedProducts()
        ]);
    }
}
