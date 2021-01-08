<?php

namespace App\Observers;

use App\Product;
use App\ProductStock;

class ProductObserver
{
    public function created(Product $product)
    {
        ProductStock::create([
            "product_id" => $product->id,
            "type" => "in",
            "qty" => $product->qty,
            "last_stock" => $product->qty
        ]);
    }
}
