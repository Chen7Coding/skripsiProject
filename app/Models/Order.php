<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        "shipping_cost",
        'status',
        'payment_status',
        'payment_method',
        'name',        
        'phone',      
        'email',       
        'address', 
        'kecamatan',
        'shipping_city',        
        'shipping_province',    
        'shipping_postal_code',
        
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function pelanggan(): BelongsTo
    {
        // Asumsi: tabel orders memiliki kolom 'user_id'
        // yang terhubung ke 'id' di tabel 'users'
        return $this->belongsTo(User::class, 'user_id'); // Ganti 'User::class' dengan model pelanggan jika berbeda
    }
}