<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'name', 'slug', 'description', 'price', 'image'];

    public function orderItems () {
        return $this->hasMany(OrderItem::class);
    }

    // Tambahkan relasi ini
    public function productOptions()
    {
        return $this->hasMany(ProductOption::class);
    }
}