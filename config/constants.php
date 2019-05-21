<?php
/*
|--------------------------------------------------------------------------
| Application Constants
|--------------------------------------------------------------------------
|
| Define application constants to be used for varying situations.
|
*/
define('ENV_DEVELOPMENT', 'local');
define('ENV_STAGING', 'staging');
define('ENV_PRODUCTION', 'production');

/*
|--------------------------------------------------------------------------
| Set The Frontend/Backend Constants
|--------------------------------------------------------------------------
|
| These constants will be used throughout the app to define
| specific functionality which relates to or depends on
| the user being in the frontend or backend.
|
*/
if (!empty($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/admin') !== false)
    define('IS_FRONTEND', false);
else
    define('IS_FRONTEND', true);