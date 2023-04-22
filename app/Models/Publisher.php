<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publisher extends BaseModel
{
    use HasFactory;

    const PUBLISHERS = [
        'PACKT',
        'Pan Macmillan India',
        'HarperCollins Publishers India',
        'Arihant Books',
        'Jaico Publishing House',
        'Hinkler'
    ];

    /**
     * @return HasMany
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'publisherId');
    }

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uniquePublisherId';
    }
}
