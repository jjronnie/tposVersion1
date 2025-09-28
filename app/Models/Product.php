<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToBusiness;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory, BelongsToBusiness;

    protected $fillable = [
        'name',
        'description',
        'type',
        'purchase_price',
        'selling_price',
        'unit',
        'quantity',
        'quantity_alert',
        'barcode',
        'barcode_image_path',
        'avatar',
        'is_active',
        'created_by'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // Optional: Scope for low stock products
    public function scopeLowStock($query)
    {
        return $query->whereColumn('quantity', '<=', 'quantity_alert');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Price margin
    public function margin(): float
    {
        return (float) $this->selling_price - (float) $this->purchase_price;
    }

    // ---  BOOT METHOD FOR AUTOMATION ---
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                // 1. Set the user who created the product
                $model->created_by = Auth::id();

                // 2. Automatically generate a unique barcode if one isn't provided
                if (empty($model->barcode)) {
                    $model->barcode = self::generateUniqueBarcode();
                }
            }
        });
    }


    /**
     * Generate a unique barcode for the product.
     * This example uses a random 12-digit number (common EAN/UPC length).
     * For production, you might integrate with a specific barcode library.
     */
    protected static function generateUniqueBarcode()
    {
        do {
            // Generate a 12-digit numeric string
            $barcode = Str::random(12);
            // Optionally, ensure it's numeric if required by your system:
            // $barcode = str_pad(mt_rand(1, 999999999999), 12, '0', STR_PAD_LEFT);
        } while (self::where('barcode', $barcode)->exists());

        return $barcode;
    }


}
