<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    protected $fillable = ['item_id', 's3_key', 's3_url', 'original_filename', 'file_size'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
