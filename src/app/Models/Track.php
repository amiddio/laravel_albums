<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Track extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'album_id',
        'disc',
        'number',
        'title',
        'duration',
        'composers',
        'performers',
    ];

    protected $casts = [
        'album_id' => 'int',
        'disc' => 'int',
        'number' => 'int',
        'title' => 'string',
        'duration' => 'string',
        'composers' => 'string',
        'performers' => 'string',
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
