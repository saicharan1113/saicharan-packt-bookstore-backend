<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GenreController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        return new JsonResponse(
            [
                'response' => Genre::select(['name', 'uniqueGenreId'])->orderBy('name', 'ASC')->get()
            ],
            Response::HTTP_OK
        );
    }
}
