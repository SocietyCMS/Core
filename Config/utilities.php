<?php

return [

    'javascript' => [

        /*
         |--------------------------------------------------------------------------
         | View to Bind JavaScript Vars To
         |--------------------------------------------------------------------------
         |
         | Set this value to the name of the view (or partial) that
         | you want to prepend all JavaScript variables to.
         | This can be a single view, or an array of views.
         | Example: 'footer' or ['footer', 'bottom']
         |
         */
        'bind_js_vars_to_this_view' => '*partials.utilities',

        /*
        |--------------------------------------------------------------------------
        | JavaScript Namespace
        |--------------------------------------------------------------------------
        |
        | Variables will be added to this Namespace.
        | That way, you can access vars, like "SomeNamespace.someVariable."
        |
        */
        'js_namespace' => 'societycms',

    ],

];
