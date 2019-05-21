<?php
/*
 * Controllers Within The "App\Http\Controllers\Admin" Namespace
*/
Route::group([
		'prefix' => 'admin',
		'namespace' => 'Admin',
		'middleware' => 'web'
		], function() {
	Route::group([
			'middleware' => 'admin.auth'
			], function() {
		/*
		|--------------------------------------------------------------------------
		| Users
		|--------------------------------------------------------------------------
		|
		| Routes related to users module.
		|
		*/
		Route::resource('users', 'UsersController');
	});
});