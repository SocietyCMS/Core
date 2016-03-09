<?php

namespace Modules\Core\Composers;

use Illuminate\Contracts\View\View;
use Modules\Core\Utilities\AssetManager\Pipeline\AssetPipeline;

class MasterViewComposer
{
    /**
     * @var AssetPipeline
     */
    private $assetPipeline;

    public function __construct()
    {
    }

    public function compose(View $view)
    {
    }
}
