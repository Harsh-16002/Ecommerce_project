<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'landmark',
        'city',
        'state',
        'pincode',
        'country',
        'phone',
        'status',
        'user_id',
        'product_id',
        'payment_status',
        'transaction_id',
        'payment_date',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
