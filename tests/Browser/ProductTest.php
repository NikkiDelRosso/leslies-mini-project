<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Product;

class ProductTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $product = Product::inRandomOrder()->first();
        $related = $product->getRelatedProducts()->first();

        $this->browse(function (Browser $browser) use ($product, $related) {
            $browser->visit('/')
                    ->assertSee('Our Products')
                    ->waitForText($product->name)
                    ->click('#product_link_' . $product->id)
                    ->waitForText('Contact us about this item')
                    ->assertSee($product->name)
                    ->assertSee('Brand: ' . $product->brand)
                    ->assertSee($product->description);

            if (!is_null($related)) {
                $browser->assertSee($related->product->name)
                    ->click('#product_link_' . $related->product->id)
                    ->waitForText($related->product->description);
            }

            $browser->click('.back-to-all')
                ->waitForText('Our Products');
        });
    }
}
