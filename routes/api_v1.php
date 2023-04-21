<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return new \Symfony\Component\HttpFoundation\JsonResponse(['Hello'], 200);
});
