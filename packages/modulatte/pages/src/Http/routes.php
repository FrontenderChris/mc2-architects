<?php
/*
|--------------------------------------------------------------------------
| Pages
|--------------------------------------------------------------------------
|
| Routes related to pages.
|
*/
Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'admin.auth'],
], function() {
    Route::resource('pages', 'PageController', ['except' => ['create']]);
    Route::get('pages/create/{form}', ['as' => 'admin.pages.create', 'uses' => 'PageController@create']);
    Route::post('pages/sort', ['as' => 'admin.pages.sort', 'uses' => 'PageController@sort']);
    Route::post('pages/toggle/{id}', ['as' => 'admin.pages.toggle', 'uses' => 'PageController@toggleVisibility']);
});