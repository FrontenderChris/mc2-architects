<?php
/**
 * This site uses the spatie/laravel-analytics extention
 * For more information on available methods etc see the URL below
 * https://github.com/spatie/laravel-analytics
 *
 * INSTALLATION
 * To install this you only need to change the siteId below - see Google Analytics > Admin > View Settings > View ID
 * Then add the below serviceEmail to your account permissions - Google Analytics > Admin > Property (or View) > User Management > Add the email
 */

return

    [
        /*
         * The siteId is used to retrieve and display Google Analytics statistics
         * in the admin-section.
         *
         * Should look like: ga:xxxxxxxx.
         */
        'siteId' => '',

        /*
         * Set the client id
         *
         * Should look like:
         * xxxxxxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.apps.googleusercontent.com
         */
        'clientId' => 'efd07698164b8aa29b23be991ad75cdef25c56b2',

        /*
         * Set the service account name
         *
         * Should look like:
         * xxxxxxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@developer.gserviceaccount.com
         */
        'serviceEmail' => '728425166170-compute@developer.gserviceaccount.com',

        /*
         * You need to download a p12-certifciate from the Google API console
         * Be sure to store this file in a secure location.
         */
        'certificatePath' => storage_path('laravel-analytics/BPB-CMS-efd07698164b.p12'),

        /*
         * The amount of minutes the Google API responses will be cached.
         * If you set this to zero, the responses won't be cached at all.
         */
        'cacheLifetime' => 60 * 24 * 2,

        /*
         * The amount of seconds the Google API responses will be cached for
         * queries that use the real time query method. If you set this to zero,
         * the responses of real time queries won't be cached at all.
         */
        'realTimeCacheLifetimeInSeconds' => 5,
    ];
