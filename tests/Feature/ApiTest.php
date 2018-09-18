<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Product;

class ApiTest extends TestCase
{
    /**
     * Test that the product list can be retrieved and has the correct structure
     *
     * @return void
     */
    public function testProductList()
    {
        $this->get('api/products')
            ->assertStatus(200)
            ->assertJsonStructure([
                'products' => [
                    [
                        'id',
                        'name',
                        'brand',
                        'type',
                        'thumbnail' => [
                            'image_url'
                        ]
                    ]
                ]
            ]);
    }

        /**
     * Test that the product list can be retrieved and has the correct structure
     *
     * @return void
     */
    public function testProductDetails()
    {
        $product = Product::inRandomOrder()->first();
        $this->get('api/products/' . $product->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'product' => [
                    'id',
                    'name',
                    'brand',
                    'type',
                    'description',
                    'atts' => [],
                    'images' => [],
                ],
                'related_products' => []
            ]);
    }
}
