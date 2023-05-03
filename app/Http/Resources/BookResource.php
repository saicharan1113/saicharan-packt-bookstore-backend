<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BookResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'uniqueBookId'      => $this->uniqueBookId,
            'title'             => $this->title,
            'description'       => $this->description,
            'isbn'              => $this->isbn,
            'image'             => $this->media ? Storage::temporaryUrl($this->media->path, now()->addMinute(10)) : null,
            'genre'             => $this->genre->name,
            'uniqueGenreId'     => $this->genre->uniqueGenreId,
            'author'            => $this->author->name,
            'uniqueAuthorId'    => $this->author->uniqueUserId,
            'publisher'         => $this->publisher->name,
            'uniquePublisherId' => $this->publisher->uniquePublisherId,
            'publishedOn'       => $this->createdAt->format('Y-m-d h:i:s'),
        ];
    }
}
