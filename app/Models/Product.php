<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'name', 'slug', 'description', 'price', 'image', 'price_per_sqm',
    'unit',];

    public function orderItems () {
        return $this->hasMany(OrderItem::class);
    }

     public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}