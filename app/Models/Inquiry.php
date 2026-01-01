<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inquiry extends Model
{
    protected $fillable = ['email', 'city', 'additional_notes'];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
