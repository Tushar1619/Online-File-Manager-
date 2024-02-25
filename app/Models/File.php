<?php

namespace App\Models;

use App\Traits\HasCreatorAndUpdater;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;

class File extends Model
{
    //the node trait is added to make the file as a nestedset node
    //so that it can access functions like makeRoot() etc
    use HasFactory, HasCreatorAndUpdater, NodeTrait, SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(File::class, 'parent_id');
    }

    public function isRoot()
    {
        return $this->parent_id == null;
    }

    //calculating the size of the files in a readable format.
    public function get_file_size()
    {
        // lets say the size = 5000B
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        // (log(5000, 1024)) = 1.2 , floor would be 1 
        $power = $this->size > 0 ? floor(log($this->size, 1024)) : 0;
        // $power = 1
        // return number_format(5000/1024) 2 places after decimal + KB
        return number_format($this->size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
        // . is decimal seperator , is thousand seperator
    }
    //setting the value of the owner
    public function owner(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return $attributes['created_by'] == Auth::id() ? 'me' : $this->user->name;
            }
        );
    }

    public function isOwnedBy($userId): bool
    {
        return $this->created_by == $userId;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->parent) {
                return;
            }
            $model->path = (!$model->parent->isRoot() ? $model->parent->path . '/' : '') . Str::slug($model->name);
        });
    }
}