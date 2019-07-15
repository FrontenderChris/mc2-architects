<?php

namespace Modulatte\Cropper;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class CropperServiceProvider extends BaseServiceProvider
{
    const NAME_SPACE = 'cropper';

    /**
     * @param Router $router
     */
    public function boot(Router $router)
    {
        parent::boot($router);
        $this->setupRoutes($router);
        $this->setupViews();
        $this->setupPublishing();
    }

    /**
     * @param Router $router
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Modulatte\Cropper\Http\Controllers'], function () {
            require __DIR__ . '/Http/routes.php';
        });
    }

    public function setupViews()
    {
        // Enables things like view('cropper::partials._input')
        $this->loadViewsFrom(__DIR__ . '/views', 'cropper');
    }

    public function setupPublishing()
    {
        $this->publishes([
            __DIR__ . '/config' => config_path(),
            __DIR__ . '/assets/js' => base_path('src/cms/js/' . self::NAME_SPACE),
            __DIR__ . '/assets/sass' => base_path('src/cms/sass/' . self::NAME_SPACE),
            __DIR__ . '/assets/images' => public_path('cms/images/vendor'),
        ], 'mandatory');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/' . self::NAME_SPACE),
        ], 'views');
    }

    /**
     *
     */
    public function register()
    {

    }
}
