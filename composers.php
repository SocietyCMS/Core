<?php

// Creators
view()->creator('partials.sidebar', \Modules\Core\Composers\SidebarViewCreator::class);

// Composers
view()->composer('*', \Modules\Core\Composers\CurrentUserComposer::class);
view()->composer('*', \Modules\Core\Composers\JWTokenViewComposer::class);
view()->composer('partials.footer', \Modules\Core\Composers\ApplicationVersionViewComposer::class);