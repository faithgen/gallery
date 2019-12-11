<?php

use FaithGen\Gallery\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

Route::name('albums.')->prefix('albums/')->group(function () {
    Route::get('/', [AlbumController::class, 'index']);
    Route::get('/view', [AlbumController::class, 'view']);
});
