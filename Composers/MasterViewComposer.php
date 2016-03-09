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

    public function __construct(AssetPipeline $assetPipeline)
    {
        $this->assetPipeline = $assetPipeline;
    }

    public function compose(View $view)
    {
        $view->with('cssFiles', $this->assetPipeline->allCss());
        $view->with('jsFiles', $this->assetPipeline->allJs());
    }
}
