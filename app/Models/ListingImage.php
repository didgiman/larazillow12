<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingImage extends Model
{
    protected $fillable = ['filename'];
    protected $appends = ['src'];
    
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function getSrcAttribute()
    {
        return asset("storage/{$this->filename}");
    }
}
