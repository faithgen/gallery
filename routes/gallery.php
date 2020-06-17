<?php

use FaithGen\Gallery\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

Route::name('albums.')->prefix('albums/')->group(function () {
    Route::get('/', [AlbumController::class, 'index']);
    Route::get('view/{album}', [AlbumController::class, 'view']);
    Route::get('comments/{album}', [AlbumController::class, 'comments']);
    Route::post('comment/{album}', [AlbumController::class, 'comment']);
});
