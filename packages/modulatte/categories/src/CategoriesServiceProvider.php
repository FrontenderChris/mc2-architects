<?php

namespace Modulatte\Categories;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class CategoriesServiceProvider extends BaseServiceProvider
{
    const NAME_SPACE = 'categories';

    /**
     * @param Router $router
     */
    public function boot(Router $router)
    {
        parent::boot($router);
        $this->setupRoutes($router);
        $this->setupViews();
        $this->setupPublishing();
        $this->setupBreadcrumbs();
        $this->setupHelpers();
    }

    /**
     * @param Router $router
     */
    protected function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Modulatte\Categories\Http\Controllers\Admin'], function () {
            require __DIR__ . '/Http/routes.php';
        });
    }

    /**
     *
     */
    protected function setupViews()
    {
        // Enables things like view('cropper::partials._input')
        $this->loadViewsFrom(__DIR__ . '/views', self::NAME_SPACE);
    }

    /**
     *
     */
    protected function setupPublishing()
    {
        $this->publishes([
            __DIR__ . '/assets/js' => base_path('src/cms/js/' . self::NAME_SPACE),
            __DIR__ . '/assets/sass' => base_path('src/cms/sass/' . self::NAME_SPACE),
            __DIR__ . '/config' => base_path('config'),
        ], 'mandatory');

        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/' . self::NAME_SPACE),
        ], 'views');
    }

    protected function setupBreadcrumbs()
    {
        if (class_exists('Breadcrumbs'))
            require __DIR__ . '/Http/breadcrumbs.php';
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
