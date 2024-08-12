<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'products';

    protected $fillable = [
        'name', 
        'description',
        'category_id', 
        'price', 
        'promo_price', 
        'in_promo', 
        'quantity'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
