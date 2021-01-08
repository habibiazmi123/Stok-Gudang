<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $table = "product_stock";
    protected $fillable = ["product_id", "type", "qty", "last_stock"];

    public function getCreatedAtAttribute($value)
    {
        return now()->parse($value)->addHours(7)->format("Y-m-d H:i");
    }
}
