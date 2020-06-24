<?php

use FaithGen\Gallery\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

Route::name('albums.')
    ->prefix('albums/')
    ->middleware('source.site')
    ->group(function () {
        Route::post('', [AlbumController::class, 'create']);
        Route::post('{album}/add-images', [AlbumController::class, 'addImage']);
        Route::put('/update/{album}', [AlbumController::class, 'update']);
        Route::delete('{album}', [AlbumController::class, 'destroy']);
        Route::delete('{album}/delete-image/{image_id}', [AlbumController::class, 'destroyImage']);
    });
