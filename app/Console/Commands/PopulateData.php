<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Leslies\LesliesApiWrapper;
use App\Product;
use App\ProductImage;

class PopulateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leslies:populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Populate data from the Leslie's API";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $api = new LesliesApiWrapper;

        $ids = $api->listProducts();

        foreach ($ids as $id) {
            $data = $api->getProduct($id);
            $this->saveProduct($data);
        }
    }

    public function saveProduct($data)
    {
        // Save these fields directly to the model
        $save_fields = [
            'id', 'description', 'type', 'name', 'brand'
        ];


        $product = new Product;

        foreach ($save_fields as $field) {
            if (isset($data->{$field})) {
                $product->{$field} = $data->{$field};
            }
        }

        $product->save();

        // Save product images
        if (isset($data->images) && is_array($data->images)) {
            foreach ($data->images as $i => $url) {
                $product->images()->create([
                    'image_url' => $url,
                    'order' => $i
                ]);
            }
        }

        if ($product->images()->count()) {
            $product->thumbnail()->associate($product->images()->first());
            $product->save();
        }

        // Get all other fields and save them as product attributes
        $attribute_fields = array_diff(
            array_keys(get_object_vars($data)),
            $save_fields,
            ['images']
        );

        foreach ($attribute_fields as $attr) {
            $product->attributes()->create([
                'key' => $attr,
                'value' => $data->{$attr}
            ]);
        }

        
    }
}
