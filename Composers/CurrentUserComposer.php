<?php

namespace Modules\Core\Composers;

use Illuminate\Contracts\View\View;
use Modules\Core\Contracts\Authentication;

class CurrentUserComposer
{
    /**
     * @var Authentication
     */
    private $auth;

    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function compose(View $view)
    {
        $currentUser = $this->auth->user();
        $view->with('currentUser', $currentUser);
    }
}
