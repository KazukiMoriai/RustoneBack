<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Signature extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'photo_id',
        'wallet_address',
        'image_hash',
        'signature',
        'challenge',
        'timestamp',
    ];

    /**
     * Get the photo that owns the signature.
     */
    public function photo(): BelongsTo
    {
        return $this->belongsTo(Photo::class);
    }
}