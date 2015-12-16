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

];
