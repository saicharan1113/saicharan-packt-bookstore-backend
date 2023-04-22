<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof NotFoundHttpException) {

            return new JsonResponse(['response' => ['message' => 'Route Not Found!']], Response::HTTP_NOT_FOUND);
        } elseif ($e instanceof MethodNotAllowedHttpException) {

            return new JsonResponse(['response' => 'Invalid Http Method'], Response::HTTP_METHOD_NOT_ALLOWED);
        } elseif ($e instanceof ValidationException) {

            return new JsonResponse(
                [
                    'message' => $e->getMessage(),
                    'errors' => $e->errors()
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } elseif ($e instanceof ModelNotFoundException) {

            return new JsonResponse(['response' => 'Model Not Found!'], Response::HTTP_NOT_FOUND);
        } elseif ($e instanceof AuthenticationException) {
            return new JsonResponse(['response' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }

        return parent::render($request, $e);
    }
}
