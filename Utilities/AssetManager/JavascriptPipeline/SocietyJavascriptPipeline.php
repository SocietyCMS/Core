<?php

namespace Modules\Core\Utilities\AssetManager\JavascriptPipeline;

use Illuminate\Support\Collection;
use Modules\Core\Utilities\AssetManager\Exceptions\AssetNotFoundException;

/**
 * Class SocietyJavascriptPipeline
 * @package Modules\Core\Utilities\AssetManager\JavascriptPipeline
 */
class SocietyJavascriptPipeline implements JavascriptPipeline
{
    /**
     * @var Collection
     */
    protected $js;

    /**
     * SocietyJavascriptPipeline constructor.
     */
    public function __construct()
    {
        $this->js = new Collection();
    }

    /**
     * Add a javascript dependency on the view.
     *
     * @param string $js
     *
     * @throws AssetNotFoundException
     *
     * @return $this
     */
    public function addJs($js)
    {
        if (is_array($js)) {
            foreach ($js as $script) {
                $this->addJs($script);
            }

            return $this;
        }

        $this->js->push($js);

        return $this;
    }

    /**
     * Return all js files to include.
     *
     * @return \Illuminate\Support\Collection
     */
    public function allJs()
    {
        return $this->js;
    }
}
