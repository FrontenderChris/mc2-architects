<?php
/*
|--------------------------------------------------------------------------
| Blog
|--------------------------------------------------------------------------
|
| Routes related to blog.
|
*/
Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'admin.auth'],
], function() {

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    |
    | Routes related to categories.
    |
    */
    if (config('categories.enabled')) {
        Route::resource('categories', 'CategoryController', ['except' => ['show']]);
        Route::post('categories/sort', ['as' => 'admin.categories.sort', 'uses' => 'CategoryController@sort']);
        Route::put('categories/updateParent/{id}', ['as' => 'admin.categories.updateParent', 'uses' => 'CategoryController@updateParent']);
        Route::post('categories/toggle/{id}', ['as' => 'admin.categories.toggle', 'uses' => 'CategoryController@toggleVisibility']);
    }

});