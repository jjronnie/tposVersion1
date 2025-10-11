<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    // Note: SaleItem doesn't need the BelongsToBusiness trait directly
    // as it is implicitly scoped via the parent Sale model.

    protected $fillable = [
        'sale_id', 
        'product_id', 
        'product_name', 
        'selling_price', 
        'quantity', 
        'unit',
        'item_discount', 
        'item_tax', 
        'subtotal'
    ];
    
    // Relationships
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
    
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}