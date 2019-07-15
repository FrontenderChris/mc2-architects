<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Monolog Logging - Send to Sentry
|--------------------------------------------------------------------------
|
| Here we configure the monolog library to send logs (ie. \Log::error)
| to Sentry as well as the default handler. This could be improved at a
| later date to have a cleaner solution, but for now this will have to do :)
|
*/
$envFile = explode("\n", file_get_contents(base_path('.env')));
$env = [];
foreach ($envFile as $value) {
    if (!empty(trim($value))) {
        $tmp = explode('=', $value);
        $env[$tmp[0]] = (!empty($tmp[1]) ? $tmp[1] : '');
    }
}

if (!empty($env['SENTRY_DSN']) && $env['APP_ENV'] != 'local') {
    $app->configureMonologUsing(function($monolog) use ($env) {
        $client = new Raven_Client($env['SENTRY_DSN']);

        $handler = new Monolog\Handler\RavenHandler($client);
        $handler->setFormatter(new Monolog\Formatter\LineFormatter("%message% %context% %extra%\n"));

        $monolog->pushHandler($handler);
    });
}

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
