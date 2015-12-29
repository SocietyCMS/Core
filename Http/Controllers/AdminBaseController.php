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
     * AdminBaseController constructor.
     */
    public function __construct()
    {
        $this->apiDispatcher = app('Dingo\Api\Dispatcher');
    }
}
