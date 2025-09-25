<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Business;
use App\Traits\BelongsToBusiness;

class Customer extends Model
{
    use HasFactory, BelongsToBusiness;


    protected $fillable = [

        'business_id',
        'name',
        'avatar',
        'email',
        'phone',
        'address',
        'tin_number',
        'status',
        'çreated_by'
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

        public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }
}
