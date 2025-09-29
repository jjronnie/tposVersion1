<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\BelongsToBusiness;

class Supplier extends Model
{
      use HasFactory, BelongsToBusiness;
    protected $fillable = [
        'business_id',
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'notes',
        'status',
        'opening_balance',
        'tax_id',
        'created_by', 
    ];

       public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }



     public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
