<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'artist_id',
        'release_type_id',
        'title',
        'year',
        'duration',
        'label',
        'genres',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'artist_id' => 'int',
        'release_type_id' => 'int',
        'title' => 'string',
        'year' => 'int',
        'duration' => 'string',
        'label' => 'string',
        'genres' => 'string',
    ];

    /**
     * @return BelongsTo
     */
    public function releaseType(): BelongsTo
    {
        return $this->belongsTo(ReleaseType::class);
    }

    /**
     * @return BelongsTo
     */
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    /**
     * @return HasMany
     */
    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }
}
