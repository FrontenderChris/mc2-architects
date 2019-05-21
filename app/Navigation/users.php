<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */
    'Users' => [
        'active' => request()->is('admin/users*'),
        'url' => route('admin.users.index'),
        'sort_order' => 90,
    ],
];