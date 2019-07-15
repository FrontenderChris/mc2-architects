<?php

namespace Modulatte\Pages;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Modulatte\Pages\Models\Page;

class PagesServiceProvider extends BaseServiceProvider
{
    const NAME_SPACE = 'pages';

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
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Modulatte\Pages\Http\Controllers'], function () {
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
            __DIR__ . '/views/forms' => Page::formPath(),
            __DIR__ . '/views/page/index.blade.php' => resource_path('views/vendor/' . self::NAME_SPACE . '/page/index.blade.php'),
            __DIR__ . '/config' => config_path(),
            __DIR__ . '/database/seeds' => database_path('seeds'),
            __DIR__ . '/database/factories' => database_path('factories'),
            __DIR__ . '/Navigation' => app_path('Navigation'),
            __DIR__ . '/assets/cms/js' => base_path('src/cms/js/' . self::NAME_SPACE),
            __DIR__ . '/assets/cms/sass' => base_path('src/cms/sass/' . self::NAME_SPACE),
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
