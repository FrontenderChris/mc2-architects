<?php
/*
* Controllers Within The "App\Http\Controllers\Admin" Namespace
*/
Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => 'web'
], function(){

    Route::group(['middleware' => 'admin.auth'], function()
    {
        Route::get('redactor/getImages', ['as' => 'admin.redactor.getImages', 'uses' => 'RedactorController@getImages']);
        Route::post('redactor/saveImage', ['as' => 'admin.redactor.saveImage', 'uses' => 'RedactorController@saveImage']);

        Route::get('redactor/getFiles', ['as' => 'admin.redactor.getImages', 'uses' => 'RedactorController@getFiles']);
        Route::post('redactor/saveFile', ['as' => 'admin.redactor.saveImage', 'uses' => 'RedactorController@saveFile']);
    });

});
