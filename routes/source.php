<?php

use FaithGen\Gallery\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

Route::name('albums.')
    ->prefix('albums/')
    ->middleware('source.site')
    ->group(function () {
        Route::post('/create', [AlbumController::class, 'create']);
        Route::post('/add-images', [AlbumController::class, 'addImage']);
        Route::put('/update', [AlbumController::class, 'update']);
        Route::delete('/delete', [AlbumController::class, 'destroy']);
        Route::delete('/delete-image', [AlbumController::class, 'destroyImage']);
    });
