<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
    ];

    public function business(): HasMany
    {
        return $this->hasMany(Business::class);
    }
}
