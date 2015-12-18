<?php

namespace Modules\Core\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

abstract class PublicBaseController extends Controller
{
    /**
     * @var \Modules\Core\Contracts\Authentication
     */
    protected $auth;

    public function __construct()
    {
        $this->auth = app('Modules\Core\Contracts\Authentication');
        // TODO Remove? no current user in public section
        //view()->share('currentUser', $this->auth->check());
    }
}
