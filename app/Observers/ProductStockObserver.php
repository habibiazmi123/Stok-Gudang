<?php

namespace App\Observers;

use App\Product;
use App\ProductStock;

class ProductStockObserver
{
    public function creating(ProductStock $productStock)
    {
        $product = Product::find($productStock->product_id);

        $last_stock = $product->qty;
        if ($productStock->type == "in") {
            $last_stock += $productStock->qty;
        }

        if ($productStock->type == "out") {
            $last_stock -= $productStock->qty;
        }

        $productStock->last_stock = $last_stock;

        $product->update(["qty" => $last_stock]);
    }
}
