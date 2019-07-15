<?php

namespace App\Providers;

use Auth;
use Illuminate\View\FileViewFinder;
use Illuminate\Support\Facades\Request;

class ViewServiceProvider extends \Illuminate\View\ViewServiceProvider
{
    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    public function registerViewFinder()
    {
        $this->app->singleton('view.finder', function($app) {
            $path = (Request::is('admin/*') ? 'view.pathsAdmin' : 'view.paths');
            $paths = $app['config'][$path];

            return new FileViewFinder($app['files'], $paths);
        });
    }
}
