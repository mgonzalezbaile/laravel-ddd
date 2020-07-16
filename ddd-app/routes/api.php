<?php

use App\Infrastructure\Input\Http\Api\Restful\V1\SomeResource;
use App\Infrastructure\Input\Http\Api\Restful\V1\SomeResourceCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('/v1/resources/{id}', SomeResource::class);
Route::any('/v1/resources', SomeResourceCollection::class);
