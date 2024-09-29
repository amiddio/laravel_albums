<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'genres',
        'decades',
    ];

    protected $casts = [
        'name' => 'string',
        'genres' => 'string',
        'decades' => 'string',
    ];

    public function albums(): hasMany
    {
        return $this->hasMany(Album::class);
    }
}
