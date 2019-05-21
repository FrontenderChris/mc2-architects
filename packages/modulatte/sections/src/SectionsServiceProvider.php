<?php

namespace Modulatte\Sections;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Modulatte\Pages\Models\Page;
use Modulatte\Sections\Models\Section;

class SectionsServiceProvider extends BaseServiceProvider
{
    const NAME_SPACE = 'sections';

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
        $router->group(['namespace' => 'Modulatte\Sections\Http\Controllers'], function () {
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
            __DIR__ . '/views/forms' => Section::formPath(),
            __DIR__ . '/views/section/_sections.blade.php' => Page::formPath() . '/_sections.blade.php',
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
