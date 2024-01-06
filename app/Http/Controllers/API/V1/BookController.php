<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Media;
use App\Models\User;
use App\Services\BookService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * @param BookRequest $bookRequest
     * @param BookService $bookService
     * @return JsonResponse
     * @throws \ErrorException
     */
    public function store(BookRequest $bookRequest, BookService $bookService)
    {
        $validatedData = $bookRequest->validated();
        $bookData      = $bookService->upsertBook($validatedData);

        return new JsonResponse(['response' => $bookData], Response::HTTP_CREATED);
    }

    /**
     * @param BookRequest $bookRequest
     * @param BookService $bookService
     * @return JsonResponse
     * @throws \ErrorException
     */
    public function update(BookRequest $bookRequest, BookService $bookService): JsonResponse
    {
        $validatedData = $bookRequest->validated();
        $bookData      = $bookService->upsertBook($validatedData);

        return new JsonResponse(['response' => $bookData], Response::HTTP_OK);
    }

    /**
     * @param Book $book
     * @param BookService $bookService
     * @return JsonResponse
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function delete(Book $book, BookService $bookService): JsonResponse
    {
        $data = [
            'id' => $book->uniqueBookId,
            'index' => $book->getTable()
        ];

        $book->delete();

        $bookService->deleteRecord($data);

        return new JsonResponse(['response' => 'Deleted the Book'], Response::HTTP_OK);
    }

    /**
     * @param Book $book
     * @param BookService $bookService
     * @return JsonResponse
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function get(Book $book, BookService $bookService)
    {
        $bookData = $bookService->getRecord($book);

        return new JsonResponse(['response' => $bookData], Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getBookList(Request $request,BookService $bookService)
    {
       $validatedData = $request->validate(
           [
               'author' => ['nullable', 'array'],
               'isbn'   => ['nullable', 'array'],
               'title'  => ['nullable', 'array'],
               'publicationDate' => ['nullable', 'array'],
               'genre' => ['nullable', 'array']
           ]
       );

//       return $bookService->getAll();


        return BookResource::collection(Book::paginate());
    }
//
    /**
     * @param Request $request
     * @param BookService $bookService
     * @return JsonResponse
     * @throws \ErrorException
     */
    public function upload(Request $request, BookService $bookService): JsonResponse
    {
        $validatedData = $request->validate(
            [
                'image' => ['required', 'mimes:jpg,jpeg,png,gif', 'max:2048']
            ]
        );

        $mediaData = $bookService->uploadMedia($validatedData);

        return new JsonResponse(['response' => $mediaData], Response::HTTP_CREATED);
    }

    /**
     * @param Media $media
     * @return JsonResponse
     */
    public function getMedia(Media $media): JsonResponse
    {
        $mediaData = $media ? Storage::temporaryUrl($media->path, now()->addMinute(10)) : null;

        return new JsonResponse(['response' => $mediaData], Response::HTTP_OK);
    }

    /**
     * @return Collection
     */
    public function getAuthor(): Collection
    {
        return User::select(['name', 'uniqueUserId'])->where('role', User::ROLES['author'])->get();
    }

    /**
     * @return Collection
     */
    public function getGenre(): Collection
    {
        return Genre::select(['name','uniqueGenreId'])->get();
    }

    /**
     * @return JsonResponse
     */
    public function filter(): JsonResponse
    {
        $filters = [
            'Authors',
            'Genre',
            'Publisher'
        ];


        return new JsonResponse(['response' => $filters], Response::HTTP_OK);
    }
}
