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


    protected $apiDispatcher;
    /**
     * AdminBaseController constructor.
     */
    public function __construct()
    {
        $this->apiDispatcher = app('Dingo\Api\Dispatcher');
    }
}
