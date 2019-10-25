<?php

Route::name('albums.')->prefix('albums/')->group(function () {
    Route::get('/', 'AlbumController@index');
    Route::get('/view', 'AlbumController@view');
});

