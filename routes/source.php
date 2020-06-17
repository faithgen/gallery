<?php

use FaithGen\Gallery\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

Route::name('albums.')
    ->prefix('albums/')
    ->middleware('source.site')
    ->group(function () {
        Route::post('/create', [AlbumController::class, 'create']);
        Route::post('/add-images/{album}', [AlbumController::class, 'addImage']);
        Route::put('/update/{album}', [AlbumController::class, 'update']);
        Route::delete('/delete/{album}', [AlbumController::class, 'destroy']);
        Route::delete('/delete-image', [AlbumController::class, 'destroyImage']);
    });
