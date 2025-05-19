<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait BasicConfig
{
    protected static function bootBasicConfigs(): void
    {
        if (Auth::check()) {
            static::creating(function ($model) {
                $model->uuid = (string) Str::uuid();
                $model->created_by = Auth::id();
                $model->created_at = now();
            });

            static::updating(function ($model) {
                $model->updated_by = Auth::id();
                $model->updated_at = now();
            });

            static::deleting(function ($model) {
                $model->updated_at = now();
                $model->deleted_at = now();
            });
        }

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }


}