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
        'mail-from' => [
            'title'       => 'core::settings.website.mail-from.title',
            'description' => 'core::settings.website.mail-from.description',
            'view'        => 'text',
            'default'     => 'mail@societycms.com',
        ],
    ],

];
