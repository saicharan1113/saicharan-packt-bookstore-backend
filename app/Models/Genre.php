<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends BaseModel
{
    use HasFactory;

    const GENRES = [
        'TECHNOLOGY', 'SCIENCE FICTION', 'THRILLER', 'EPIC', 'COMEDY'
    ];

    /**
     * @return HasMany
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'genreId');
    }


    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uniqueGenreId';
    }
}
