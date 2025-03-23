<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Defining the relationship with the User model
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    // Defining the relationship with the Product model
    public function product(){
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}

