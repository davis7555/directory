<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    protected $fillable = [
        'name',
        'location'
    ];

    public function business(): HasMany
    {
        return $this->hasMany(Business::class);
    }
}
