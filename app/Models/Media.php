<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model as BaseModel;


class Media extends BaseModel
{
    use HasFactory;

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uniqueMediaId';
    }
}
