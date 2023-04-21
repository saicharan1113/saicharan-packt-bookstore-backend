<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    use HasFactory;

    const CREATED_AT = 'createdAt';

    const UPDATED_AT = 'updatedAt';

    /**
     * @var string[]
     */
    protected $hidden = ['id'];

    public static $snakeAttributes = false;

    /**
     * @return int
     */
    public function getRouteKey(): int
    {
        return 'uniqueUserId';
    }

}
