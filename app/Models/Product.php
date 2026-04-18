<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'price',
        'category',
        'quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public static function integerExpression(string $column): string
    {
        $instance = new static();
        $query = $instance->newQuery()->getQuery();
        $wrappedColumn = $query->getGrammar()->wrap($column);
        $driver = $instance->getConnection()->getDriverName();

        return match ($driver) {
            'pgsql' => "CAST($wrappedColumn AS INTEGER)",
            default => "CAST($wrappedColumn AS SIGNED)",
        };
    }

    public static function decimalExpression(string $column): string
    {
        $instance = new static();
        $query = $instance->newQuery()->getQuery();
        $wrappedColumn = $query->getGrammar()->wrap($column);

        return "CAST($wrappedColumn AS DECIMAL(10,2))";
    }
}
