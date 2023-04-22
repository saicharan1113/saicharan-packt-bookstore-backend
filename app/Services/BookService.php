<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\User;
use App\Traits\GeneralHelperTrait;

class BookService
{
    use GeneralHelperTrait;

    /**
     * @param array $data
     * @return array
     * @throws \ErrorException
     */
    public function upsertBook(array $data): array
    {
        try {
            if (array_key_exists('uniqueBookId', $data)) {
                $message = 'Book Updated';
                $book = Book::where('uniqueBookId', $data['uniqueBookId'])->first();
            } else {
                $message = 'Book Saved';
                $book = new Book();
                $book->uniqueBookId = $this->generateUniqueId();
            }
            $book->title = $data['title'];
            $book->genreId = Genre::where('uniqueGenreId', $data['genreIdentifier'])->first()->id;
            $book->authorId = User::where('uniqueUserId', $data['authorIdentifier'])->first()->id;
            $book->publisherId = Publisher::where('uniquePublisherId', $data['publisherIdentifier'])->first()->id;
            $book->isbn = $data['isbn'];
            $book->description = $data['description'];

            $book->save();

            $result['message'] = $message;
            $result['data'] = $book->refresh();

            return $result;
        } catch (\Exception $exception) {
            $message = array_key_exists('uniqueBookId', $data) ? 'Unable to Update Book' : 'Unable to Save Book';

            throw $exception;
//            throw new \ErrorException($message) ;
        }
    }
}
