<?php
/*
* Controllers Within The "App\Http\Controllers\Admin" Namespace
*/
Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => 'web'
], function(){

    Route::auth();
    Route::get('/', function(){
        return redirect('admin/login');
    });

    //Put admin routes in here which must first pass through the \Admin\Authenticate.php middleware class
    Route::group(['middleware' => 'admin.auth'], function()
    {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        Route::resource('projects', 'ProjectController');

        /*
        |--------------------------------------------------------------------------
        | Newsletter Subscribers
        |--------------------------------------------------------------------------
        |
        | Routes related to subscribers.
        |
        */
        Route::resource('subscribers', 'SubscriberController', ['except' => ['create', 'show', 'edit', 'update', 'store', 'destroy']]);
        Route::get('subscribers/export', ['as' => 'admin.subscribers.export', 'uses' => 'SubscriberController@export']);

        /*
        |--------------------------------------------------------------------------
        | Settings
        |--------------------------------------------------------------------------
        |
        | Routes related to settings.
        |
        */
        Route::get('settings', ['as' => 'admin.settings.index', 'uses' => 'SettingsController@index']);
        Route::post('settings/update', ['as' => 'admin.settings.update', 'uses' => 'SettingsController@update']);

        /*
        |--------------------------------------------------------------------------
        | Redirects
        |--------------------------------------------------------------------------
        |
        | Routes related to 301 redirects.
        |
        */
        Route::resource('redirects', 'RedirectController');
        Route::post('redirects/toggle/{id}', ['as' => 'admin.redirects.toggle', 'uses' => 'RedirectController@toggleVisibility']);
    });

});
