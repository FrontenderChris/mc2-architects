<?php
Route::group([
    'prefix' => 'admin',
    'middleware' => 'web'
], function() {

    Route::group(['middleware' => 'admin.auth'], function()
    {
        /*
        |--------------------------------------------------------------------------
        | Gallery
        |--------------------------------------------------------------------------
        |
        | Routes related to gallery items.
        |
        */
        Route::get('gallery/getRowHtml/{id}', 'GalleryController@getRowHtml');
        Route::post('gallery/sort', ['as' => 'admin.gallery.sort', 'uses' => 'GalleryController@sort']);
        Route::resource('gallery', 'GalleryController', ['except' => ['create', 'view', 'edit']]);
        Route::get('gallery/create/{class}/{id}/{width}/{height}/{route}', ['as' => 'admin.gallery.create', 'uses' => 'GalleryController@create']);
        Route::get('gallery/{gallery}/edit/{route} ', ['as' => 'admin.gallery.edit', 'uses' => 'GalleryController@edit']);
    });

});
