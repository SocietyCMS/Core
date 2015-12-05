<?php namespace Modules\Core\Http\Controllers;

use FloatingPoint\Stylist\Facades\ThemeFacade as Theme;
use Illuminate\Routing\Controller;
use Modules\Core\Foundation\Asset\Manager\AssetManager;
use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;
use Pingpong\Modules\Facades\Module;

/**
 * Class AdminBaseController
 * @package Modules\Core\Http\Controllers
 */
class AdminBaseController extends Controller
{
    /**
     * AdminBaseController constructor.
     */
    public function __construct()
    {

    }
}
