<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Defining the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Defining the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
