<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Business;
use App\Scopes\BusinessScope;

class Customer extends Model
{
   use HasFactory;

    protected $fillable = [
        'business_id',
        'name',
        'email',
        'phone',
        'address',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
