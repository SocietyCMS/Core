<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

/**
 * Class AdminBaseController.
 */
class AdminBaseController extends Controller
{
    use ValidatesRequests;

    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $apiDispatcher;

    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * AdminBaseController constructor.
     */
    public function __construct()
    {
        $this->auth = app('Modules\Core\Contracts\Authentication');
        $this->apiDispatcher = app('Dingo\Api\Dispatcher');
    }
}
