<?php

use FaithGen\Gallery\Http\Controllers\AlbumController;
use FaithGen\Gallery\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::name('albums.')->prefix('albums/')->group(function () {
    Route::get('/', [AlbumController::class, 'index']);
    Route::get('/view', [AlbumController::class, 'view']);
    Route::get('comments/{album}', [AlbumController::class, 'comments']);
    Route::post('/comment', [AlbumController::class, 'comment']);
});

Route::name('images.')->prefix('images')->group(function () {
    Route::post('comment', [ImageController::class, 'comment']);
});
