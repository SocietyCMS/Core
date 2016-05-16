<?php

namespace Modules\Core\Traits\Media;

/*
 * Class baseMediaConversions.
 */
use ReflectionClass;

/**
 * Class baseMediaConversions.
 */
trait themeMediaConversions
{
    /**
     * register media conversions.
     */
    public function registerMediaConversions()
    {
        $this->registerMediaConversionsFromTheme();
        $this->defaultMediaConversions();
        $this->additionalMediaConversions();
    }

    /**
     * register MediaConversions defined in the themes .json file.
     */
    protected function registerMediaConversionsFromTheme()
    {
        $namespace = (new ReflectionClass($this))->getNamespaceName();
        $className = strtolower(explode('\\', $namespace)[1]);
        $themeOptions = app('setting.themeOptions')->getOption("{$className}.medialibrary");

        if (! $themeOptions) {
            return;
        }

        foreach ($themeOptions as $themeOption) {
            $this->addMediaConversion($themeOption->name)
                ->setManipulations((array) $themeOption->manipulation)
                ->performOnCollections($themeOption->collection);
        }
    }

    /**
     * Default MediaConversions for all Entity.
     */
    public function defaultMediaConversions()
    {
        $this->addMediaConversion('thumbnail-square')
            ->setManipulations(['w' => 256, 'h' => 256, 'fit' => 'crop'])
            ->performOnCollections('images');

        $this->addMediaConversion('thumbnail-small')
            ->setManipulations(['w' => 250, 'h' => 250, 'fit' => 'max'])
            ->performOnCollections('images');

        $this->addMediaConversion('thumbnail-medium')
            ->setManipulations(['w' => 420, 'h' => 420, 'fit' => 'max'])
            ->performOnCollections('images');

        $this->addMediaConversion('thumbnail-large')
            ->setManipulations(['w' => 600, 'h' => 600, 'fit' => 'max'])
            ->performOnCollections('images');

        $this->addMediaConversion('originalHD')
            ->setManipulations(['w' => 1920, 'h' => 1080, 'fit' => 'max'])
            ->performOnCollections('images');
    }

    /**
     * Additional MediaConversions for this Entity.
     */
    public function additionalMediaConversions()
    {
    }
}
