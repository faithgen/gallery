<?php

use FaithGen\Gallery\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

Route::name('albums.')->prefix('albums/')->group(function () {
    Route::post('/create', [AlbumController::class, 'create'])->middleware('source.site');
    Route::post('/add-images', [AlbumController::class, 'addImage'])->middleware('source.site');
    Route::put('/update', [AlbumController::class, 'update'])->middleware('source.site');
    Route::delete('/delete', [AlbumController::class, 'destroy'])->middleware('source.site');
    Route::delete('/delete-image', [AlbumController::class, 'destroyImage'])->middleware('source.site');
});
