<?php

namespace App\Models;

use App\Traits\BelongsToBusiness;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory, BelongsToBusiness; // Apply multitenancy trait

    protected $fillable = [
        'customer_id', 
        'invoice_number', 
        'sale_date', 
        'subtotal', 
        'tax_amount', 
        'discount_amount', 
        'grand_total', 
        'amount_paid', 
        'balance', 
        'payment_status', 
        'payment_method', 
        'notes',
        'created_by',
    ];

    protected $casts = [
        'sale_date' => 'datetime',
    ];

    // Relationships
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}