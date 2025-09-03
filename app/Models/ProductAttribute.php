<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    
    // Nama tabel yang sesuai dengan database Anda
    protected $table = 'product_attributes'; // Perbaiki jika nama tabel berbeda

    protected $fillable = [
        'product_id',
        'material',
        'size',
        'price_modifier',
        'unit',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}