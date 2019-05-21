<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Admin CMS Navigation
    |--------------------------------------------------------------------------
    |
    | This is where you can add admin navigation items, packages will also
    | extend (merge) this configuration to display package navigation
    | items when required.
    |
    */
    'Dashboard' => [
        'url' => route('dashboard'),
        'active' => request()->is('admin/dashboard'),
        'sort_order' => 10,
    ],
];
