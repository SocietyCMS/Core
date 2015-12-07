<?php

namespace Modules\Core\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class CoreController extends Controller
{
    public function index()
    {
        return view('core::index');
    }
}
