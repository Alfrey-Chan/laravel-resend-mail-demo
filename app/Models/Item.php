<?php

namespace App\Models;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasUlids;
    protected $fillable = ['details'];

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }
}
