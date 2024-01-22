<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'identification_number',
        'total_value',
        'status_id',
        'paid_at',
        'canceled_at',
    ];

    protected $casts = [
        'total_value' => 'float',
        'paid_at' => 'datetime',
        'canceled_at' => 'datetime'
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(SaleStatus::class, 'status_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_sale', 'sale_id', 'product_id')
            ->withPivot('quantity', 'user_id')
            ->using(ProductSale::class);
    }
}
