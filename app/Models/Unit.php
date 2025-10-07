<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToBusiness; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{

    use HasFactory, BelongsToBusiness;
      protected $fillable = [
        'business_id',
        'name',
        'short_name',
        'created_by',
       
    ];
}
