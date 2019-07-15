<?php
namespace Modulatte\Gallery;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class GalleryServiceProvider extends BaseServiceProvider
{
    const NAME_SPACE = 'gallery';

    /**
     * @param Router $router
     */
    public function boot(Router $router)
    {
        parent::boot($router);
        $this->setupRoutes($router);
        $this->setupViews();
        $this->setupPublishing();
        $this->setupHelpers();
    }

    /**
     * @param Router $router
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Modulatte\Gallery\Http\Controllers'], function () {
            require __DIR__ . '/Http/routes.php';
        });
    }

    public function setupViews()
    {
        // Enables things like view('cropper::partials._input')
        $this->loadViewsFrom(__DIR__ . '/views', self::NAME_SPACE);
    }

    public function setupPublishing()
    {
        $this->publishes([
            __DIR__ . '/views/partials/_form.blade.php' => resource_path('views/vendor/' . self::NAME_SPACE . '/partials/_form.blade.php'),
        ], 'mandatory');

        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/' . self::NAME_SPACE),
        ], 'views');
    }

    protected function setupHelpers()
    {
        require __DIR__ . '/Http/helpers.php';
    }

    /**
     *
     */
    public function register()
    {

    }
}
