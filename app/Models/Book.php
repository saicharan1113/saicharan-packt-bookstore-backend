<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model as BaseModel;

class Book extends BaseModel
{
    use HasFactory;

    /**
     * @return int
     */
    public function getRouteKey(): int
    {
        return 'uniqueBookId';
    }
}
