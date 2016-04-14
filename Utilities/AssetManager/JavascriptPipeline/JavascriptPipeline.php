<?php

namespace Modules\Core\Utilities\AssetManager\JavascriptPipeline;

interface JavascriptPipeline
{
    /**
     * Add a javascript object to the Stack.
     *
     * @param string $js
     *
     * @return $this
     */
    public function addJs($js);

    /**
     * Return all js to include.
     *
     * @return \Illuminate\Support\Collection
     */
    public function allJs();
}
