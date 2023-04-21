<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model as BaseModel;

class Genre extends BaseModel
{
    use HasFactory;

    const GENRES = [
        'TECHNOLOGY', 'SCIENCE FICTION', 'THRILLER', 'EPIC', 'COMEDY'
    ];

    /**
     * @return int
     */
    public function getRouteKey(): int
    {
        return 'uniqueGenreId';
    }
}
