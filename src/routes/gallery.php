<?php

Route::name('albums.')->prefix('albums/')->group(function () {
    Route::get('/', 'AlbumController@index');
    Route::get('/view', 'AlbumController@view');
    Route::post('/create', 'AlbumController@create');
    Route::post('/add-images', 'AlbumController@addImage');
    Route::put('/update', 'AlbumController@update');
    Route::delete('/delete', 'AlbumController@destroy');
    Route::delete('/delete-image', 'AlbumController@destroyImage');
});

