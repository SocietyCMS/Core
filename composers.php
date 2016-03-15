<?php

// Creators
view()->creator('partials.sidebar', \Modules\Core\Composers\SidebarViewCreator::class);

// Composers
view()->composer('*', \Modules\Core\Composers\CurrentUserComposer::class);
view()->composer('layouts.master', \Modules\Core\Composers\MasterViewComposer::class);