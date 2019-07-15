<?php
/*
|--------------------------------------------------------------------------
| Image Cropper
|--------------------------------------------------------------------------
|
| Routes related to the image cropper.
|
*/
Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'admin.auth'],
], function() {
    Route::post('images/crop', ['as' => 'admin.images.crop', 'uses' => 'CropperController@crop']);
    Route::delete('images/{id}', ['as' => 'admin.images.destroy', 'uses' => 'CropperController@destroy']);
});

