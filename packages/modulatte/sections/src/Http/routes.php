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
    Route::resource('sections', 'SectionController', ['except' => ['create']]);
    Route::get('sections/create/{form}/{pageId}', ['as' => 'admin.sections.create', 'uses' => 'SectionController@create']);
    Route::post('sections/sort', ['as' => 'admin.sections.sort', 'uses' => 'SectionController@sort']);
    Route::post('sections/toggle/{id}', ['as' => 'admin.sections.toggle', 'uses' => 'SectionController@toggleVisibility']);
    Route::get('sections/getRowHtml/{id}', 'SectionController@getRowHtml');
});

