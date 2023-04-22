<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return JsonResponse
     */
    public function delete(Book $book): JsonResponse
    {
        $book->delete();

        return new JsonResponse(['response' => 'Deleted the Book'], Response::HTTP_OK);
    }

    /**
     * @param Book $book
     * @return JsonResponse
     */
    public function get(Book $book): JsonResponse
    {
        $bookData = $book->load(
            [
                'genre',
                'publisher:id,name,uniquePublisherId,createdAt',
                'author:id,name,uniqueUserId'
            ]
        );

        return new JsonResponse(['response' => new BookResource($bookData)], Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getBookList()
    {
        return BookResource::collection(Book::paginate());
    }


    public function uploadBookImage(Request $request)
    {
        $validatedData = $request->validate(
            [
                'image' => ['required', 'mimes:jpg,jpeg,png']
            ]
        );
    }
}
