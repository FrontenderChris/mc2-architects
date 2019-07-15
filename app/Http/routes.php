<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
//


Route::group(['middleware' => ['web']], function () {
    // set locale
    Route::get('lang/{locale}', ['as'=>'lang.change', 'uses'=>'LanguageController@setLocale']);

    Route::get('/projects', ['as' => 'projects', 'uses' => 'FrontendController@projects']);
    Route::get('project/{project}', ['uses' => 'FrontendController@project']);
    Route::get('/', ['as' => 'home', 'uses' => 'FrontendController@home']);
    Route::get('home', function(){
        return redirect()->route('home');
    });
    // Route::get('contact-us', ['as' => 'contact', 'uses' => 'FrontendController@contact']);
    Route::post('contact-us', ['as' => 'contact.send', 'uses' => 'FrontendController@contactSend']);
    //Route::get('contact',['as'=>'contact'], function(){
    //    return redirect()->route('page', 'contact-us');
    //});

    Route::post('subscribe', ['as' => 'subscribe', 'uses' => 'SubscribeController@subscribe']);
    Route::get('unsubscribe/{email}/{id}', ['as' => 'unsubscribe', 'uses' => 'SubscribeController@unsubscribe']);

    /*
    |--------------------------------------------------------------------------
    | Uploaded Files Routes
    |--------------------------------------------------------------------------
    |
    | Routes used for displaying images/downloads/uploads
    |
    */
    Route::get('uploads/{filename}', ['as' => 'uploads.view', 'uses' => 'UploadController@view']);
    Route::get('downloads/{filename}', ['as' => 'downloads.view', 'uses' => 'UploadController@downloads']);
    Route::get('images/{filename}', ['as' => 'images.view', 'uses' => 'UploadController@images']);

    /*
    |--------------------------------------------------------------------------
    | Sitemap Route
    |--------------------------------------------------------------------------
    |
    | Routes used to generate sitemap
    |
    */
    Route::get('sitemap.xml', 'SiteMapController@index');
    Route::get('sitemap', 'SiteMapController@html');
});

// Include all routes from /routes folder
foreach (File::allFiles(__DIR__ . '/Routes/Admin') as $partial)
    require_once $partial->getPathName();

Route::group(['middleware' => ['web']], function () {
    Route::get('robots.txt', function ()
    {
        if (strpos($_SERVER['SERVER_NAME'], '.dev') !== false || strpos($_SERVER['SERVER_NAME'], 'dev.') !== false || strpos($_SERVER['SERVER_NAME'], 'ongoing.') !== false) {
            // If you're on any other server, tell everyone to go away.
            Robots::addDisallow('*');
        } else {
            // If on the live server, serve a nice, welcoming robots.txt.
            Robots::addUserAgent('*');
            Robots::addSitemap('sitemap.xml');
        }

        return Response::make(Robots::generate(), 200, ['Content-Type' => 'text/plain']);
    });

	/*
	 * Leave this route last - default controller to read /views/pages files automatically (for frontend guys)
	* ie. /about will read the /views/pages/about.blade.php file automatically
	*/
    Route::get('{page}', ['as' => 'page', 'uses' => 'FrontendController@page'])->where('page', '.+');
});