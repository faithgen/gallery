<?php

Route::name('albums.')->prefix('albums/')->group(function () {
    Route::post('/create', 'AlbumController@create')->middleware('source.site');
    Route::post('/add-images', 'AlbumController@addImage')->middleware('source.site');
    Route::put('/update', 'AlbumController@update')->middleware('source.site');
    Route::delete('/delete', 'AlbumController@destroy')->middleware('source.site');
    Route::delete('/delete-image', 'AlbumController@destroyImage')->middleware('source.site');
});
