<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToBusiness
{
    protected static function bootBelongsToBusiness()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->business_id = Auth::user()->business_id;
            }
        });

        static::addGlobalScope('business', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where('business_id', Auth::user()->business_id);
            }
        });
    }
}
