<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasCreatorAndUpdater
{
    //this trait is used to update the values of the model's created_at and updated_at
    //values based on whether they are created or updated
    protected static function bootHasCreatorAndUpdater()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
        });
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}