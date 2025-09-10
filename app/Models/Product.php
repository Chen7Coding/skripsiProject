<?php

namespace App\Models;

use App\Models\OrderItem;
use App\Models\ProductAttribute;
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
        // Laravel secara default akan mencari 'product_id' di tabel product_attributes
        // Jadi, tidak perlu secara eksplisit menuliskannya.
        return $this->hasMany(ProductAttribute::class);
    }
}