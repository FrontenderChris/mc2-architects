<?php
/**
|--------------------------------------------------------------------------
| Example Settings
|--------------------------------------------------------------------------
'text-example' => [
    'label' => 'Email',
    'validation' => 'required|email',
    'widget' => '_text',
],
'textarea-example' => [
    'label' => 'GA Code',
    'validation' => '',
    'widget' => '_textarea',
],
'image-example' => [
    'label' => 'Logo',
    'validation' => 'required',
    'widget' => '_file',
],
'select-example' => [
    'label' => 'Test',
    'validation' => '',
    'widget' => '_select',
    'data' => [
        'inclusive' => 'Inclusive',
        'exclusive' => 'Exclusive',
    ],
],
 */

/*
|--------------------------------------------------------------------------
| General Site Settings
|--------------------------------------------------------------------------
*/
return [
    'General' => [
        'site_name' => [
            'label' => 'Site Name',
            'validation' => 'required',
            'widget' => '_text',
            'value' => 'MC2 Architects',
        ],
        'email_from' => [
            'label' => 'Emails From',
            'validation' => 'required|email',
            'widget' => '_text',
            'value' => 'info@mc2architects.co.nz',
        ],
        'email_to' => [
            'label' => 'Emails To',
            'validation' => 'required|email',
            'widget' => '_text',
            'value' => 'info@mc2architects.co.nz',
        ],
        'email_cc' => [
            'label' => 'Email CC',
            'validation' => 'email',
            'widget' => '_text',
        ],
        'phone' => [
            'label' => 'Phone',
            'validation' => 'required',
            'widget' => '_text',
            'value' => '09 846 3321'
        ],
        'ga_code' => [
            'label' => 'GA Code',
            'validation' => '',
            'widget' => '_textarea',
        ],
        'logo' => [
            'label' => 'Logo',
            'validation' => 'required',
            'widget' => '_file',
        ],
    ],
];