<?php

return [

    'core::settings.website.title' => [
        'site-name'        => [
            'title'   => 'core::settings.website.site-name',
            'view'    => 'text',
            'default' => trans('core::core.societycms'),
        ],
        'site-description' => [
            'title' => 'core::settings.website.site-description',
            'view'  => 'textarea',
        ],
    ],

    'core::settings.mail.title' => [
        'mail-from' => [
            'title'       => 'core::settings.mail.mail-from.title',
            'description' => 'core::settings.mail.mail-from.description',
            'view'        => 'text',
            'default'     => 'mail@societycms.com',
        ],
    ],

];
