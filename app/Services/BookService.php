<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\User;
use App\Traits\GeneralHelperTrait;

class BookService extends ElasticsearchService
{
    use GeneralHelperTrait;

    /**
     * @param array $data
     * @return array
     * @throws \ErrorException
     */
    public function upsertBook(array $data)
    {
        try {
            if (array_key_exists('bookIdentifier', $data)) {
                $message = 'Book Updated';
                $book = Book::where('uniqueBookId', $data['bookIdentifier'])->first();
            } else {
                $message = 'Book Saved';
                $data['uniqueBookId'] = $this->generateUniqueId();
                $book = new Book();
                $book->uniqueBookId = $data['uniqueBookId'];
            }

            $publisher = Publisher::where('uniquePublisherId', $data['publisherIdentifier'])->first();
            $genre = Genre::where('uniqueGenreId', $data['genreIdentifier'])->first();
            $user = User::where('uniqueUserId', $data['authorIdentifier'])->first();
            $book->title = $data['title'];
            $book->genreId = $genre->id;
            $book->authorId = $user->id;
            $book->publisherId = $publisher->id;
            $book->isbn = $data['isbn'];
            $book->description = $data['description'];

            $book->save();
            $result['message'] = $message;

            $params = [
                'index' => $book->getTable(),
            ];

            $params['body'] = [
                'title' => $book->title,
                'description' => $book->description,
                'author' => $user->name,
                'isbn' => $book->isbn,
                'uniqueUserId' => $user->uniqueUserId,
                'genre' => $genre->name,
                'uniqueGenreId' => $genre->uniqueGenreId,
                'publishedOn' => $book->createdAt,
                'publisher' => $publisher->name,
                'uniquePublisherId' => $publisher->uniquePublisherId,
                'uniqueBookId' => $data['bookIdentifier'] ?? $data['uniqueBookId']
            ];

                if (array_key_exists('bookIdentifier', $data)) {
                    $params = [
                        'id' =>$data['bookIdentifier'],
                        'index' => $book->getTable(),
                        'body' => [
                            'doc' => $params['body']
                        ]
                    ];

                    $result['data'] = $this->edit($params);
                } else {
                    $params['id'] = $data['uniqueBookId'];
                    $result['data'] = $this->store($params);
                }

//            $result['data'] = $book->refresh();

            return $result;
        } catch (\Exception $exception) {
            $message = array_key_exists('bookIdentifier', $data) ? 'Unable to Update Book' : 'Unable to Save Book';

            throw $exception;
//            throw new \ErrorException($message);
        }
    }

    /**
     * @param Book $book
     * @return array
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function getRecord(Book $book): array
    {
        $params = [
            'index' => $book->getTable(),
            'id' => $book->uniqueBookId,
        ];

        return $this->getDocument($params);
    }

    /**
     * @param array $params
     * @return array
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function deleteRecord(array $params): array
    {
       return $this->deleteDocument($params);
    }

    public function getList()
    {

        $params = [
            ['index' =>'books', 'id' => '*'],
        ];

        return $this->client->search($params)->hits->hits;
    }
}
