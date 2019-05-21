<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Project CMS Navigation
    |--------------------------------------------------------------------------
    |
    */
    'Projects' => [
        'url' => route('admin.projects.index'),
        'active' => request()->is('admin/projects*'),
        'sort_order' => 20,
    ],
];