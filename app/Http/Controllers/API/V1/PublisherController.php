<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublisherController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        return new JsonResponse(
            [
                'response' => Publisher::select(['name', 'uniquePublisherId'])->orderBy('name', 'ASC')->get()
            ],
            Response::HTTP_OK
        );
    }


}
