<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Pages CMS Navigation
    |--------------------------------------------------------------------------
    |
    */
    'Pages' => [
        'url' => route('admin.pages.index'),
        'active' => request()->is('admin/pages*'),
        'sort_order' => 20,
    ],
];