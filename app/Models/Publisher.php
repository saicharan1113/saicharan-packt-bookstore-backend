<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model as BaseModel;

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
     * @return int
     */
    public function getRouteKey(): int
    {
        return 'uniquePublisherId';
    }
}
