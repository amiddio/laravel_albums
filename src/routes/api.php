<?php

use App\Http\Controllers\Api\V1\AlbumController;
use App\Http\Controllers\Api\V1\ArtistController;
use App\Http\Controllers\Api\V1\ReleaseTypeController;
use App\Http\Controllers\Api\V1\TrackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function () {
    Route::get('release_types', ReleaseTypeController::class);
    Route::apiResource('artists', ArtistController::class);
    Route::apiResource('albums', AlbumController::class)->except('index');
    Route::get('albums/{artistId}/{resourceTypeId}', [AlbumController::class, 'index'])->name('albums.index');
    Route::apiResource('tracks', TrackController::class)->except('index', 'show');
});
