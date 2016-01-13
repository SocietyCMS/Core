<?php

namespace Modules\Core\Traits\Factory;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Faker\Generator as FakerGenerator;


trait useFactories
{
    function factory()
    {
        $faker = app(FakerGenerator::class);
        $factory = EloquentFactory::construct($faker);

        foreach (app('modules')->enabled() as $module) {
            $factory->load("modules/{$module}/Database/Factories");
        }

        $arguments = func_get_args();

        if (isset($arguments[1]) && is_string($arguments[1])) {
            return $factory->of($arguments[0], $arguments[1])->times(isset($arguments[2]) ? $arguments[2] : 1);
        } elseif (isset($arguments[1])) {
            return $factory->of($arguments[0])->times($arguments[1]);
        } else {
            return $factory->of($arguments[0]);
        }

    }

}