<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Routing\Controller;

/**
 * Class AdminBaseController.
 */
class AdminBaseController extends Controller
{

    protected $apiDispatcher;
    /**
     * AdminBaseController constructor.
     */
    public function __construct()
    {
        $this->apiDispatcher = app('Dingo\Api\Dispatcher');
    }
}
