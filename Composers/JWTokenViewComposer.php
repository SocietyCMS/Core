<?php namespace Modules\Core\Composers;

use Illuminate\Contracts\View\View;
use Modules\Core\Contracts\Authentication;

class JWTokenViewComposer
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
        if ($user = $this->auth->check()) {
            $view->with('jwtoken', \JWTAuth::fromUser($user));
        }
    }
}
