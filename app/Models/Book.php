<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $hidden = ['id', 'genreId', 'publisherId', 'authorId', 'deletedAt', 'updatedAt'];

    /**
     * @var string[]
     */
    protected $casts = [
        'createdAt' => 'datetime:Y-m-d h:i:s'
    ];


    /**
     * @return BelongsTo
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'genreId');
    }

    /**
     * @return BelongsTo
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class, 'publisherId');
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'authorId');
    }

    /**
     * @return BelongsTo
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'mediaId');
    }

    /**
     * @return string
     */
   final public function getRouteKeyName(): string
    {
        return 'uniqueBookId';
    }
}
