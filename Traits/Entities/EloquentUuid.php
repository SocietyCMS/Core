<?php

namespace Modules\Core\Traits\Entities;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Class EloquentUuid
 * @package Modules\Core\Traits\Entities
 */
trait EloquentUuid
{

    /**
     * Boot EloquentUuid trait for the model.
     *
     * @return void
     */
    public static function bootEloquentUuid()
    {
        static::creating(function ($model) {
            $model->incrementing = false;
            $model->{$model->getKeyName()} = (string)Uuid::uuid4();
        });
    }
}
