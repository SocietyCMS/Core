<?php

namespace Modules\Core\Traits\Media;

/**
 * Class baseMediaConversions
 * @package Modules\Core\Traits\Media
 */
trait baseMediaConversions
{

    /**
     *
     */
    public function registerMediaConversions()
    {
        $this->addMediaConversion('square100')
            ->setManipulations(['w' => 100, 'h' => 100, 'fit' => 'crop'])
            ->performOnCollections('images');

        $this->addMediaConversion('square200')
            ->setManipulations(['w' => 200, 'h' => 200, 'fit' => 'crop'])
            ->performOnCollections('images');

        $this->addMediaConversion('wide160')
            ->setManipulations(['w' => 160, 'h' => 90, 'fit' => 'crop'])
            ->performOnCollections('images');

        $this->addMediaConversion('wide320')
            ->setManipulations(['w' => 320, 'h' => 180, 'fit' => 'crop'])
            ->performOnCollections('images');

        $this->addMediaConversion('original100')
            ->setManipulations(['w' => 100, 'h' => 100, 'fit' => 'max'])
            ->performOnCollections('images');

        $this->addMediaConversion('original180')
            ->setManipulations(['w' => 180, 'h' => 180, 'fit' => 'max'])
            ->performOnCollections('images');

        $this->addMediaConversion('original250')
            ->setManipulations(['w' => 250, 'h' => 250, 'fit' => 'max'])
            ->performOnCollections('images');

        $this->addMediaConversion('original400')
            ->setManipulations(['w' => 400, 'h' => 400, 'fit' => 'max'])
            ->performOnCollections('images');

        $this->addMediaConversion('cover400')
            ->setManipulations(['w' => 400, 'h' => 400,  'fit' => 'crop'])
            ->performOnCollections('images');

        $this->addMediaConversion('cover900')
            ->setManipulations(['w' => 900, 'h' => 200,  'fit' => 'crop'])
            ->performOnCollections('images');
    }
}
