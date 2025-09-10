<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //order item
    protected $fillable = [
    'order_id', 'product_id', 'material', 'size', 'quantity', 'price', 'design_file_path', 'notes' ,'unit'
    ];

    public function product (){
        return $this->belongsTo(Product::class);
    }
}
