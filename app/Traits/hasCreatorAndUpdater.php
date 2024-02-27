<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasCreatorAndUpdater
{
    //this trait is used to update the values of the model's created_at and updated_at
    //values based on whether they are created or updated
// bootHasCreatorAndUpdater Method: This method is automatically called by Laravel's booting mechanism when the trait is booted. It registers event listeners for the creating and updating events of the model.
    protected static function bootHasCreatorAndUpdater()
    {
        // these are the event listeners
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
        });
        // event listener
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}