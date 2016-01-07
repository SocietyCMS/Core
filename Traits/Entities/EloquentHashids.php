<?php

namespace Modules\Core\Traits\Entities;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Class EloquentHashids
 * @package Modules\Core\Traits\Entities
 */
trait EloquentHashids
{

    /**
     * Boot Eloquent Hashids trait for the model.
     *
     * @return void
     */
    public static function bootEloquentHashids()
    {
        static::created(function (Model $model)
        {
            $model->{static::getHashidColumn($model)} = Hashids::connection(static::getHashidConnection($model))->encode(static::getHashidEncodingValue($model));
            $model->save();
        });
    }
    /**
     * @param Model $model
     * @return string
     */
    public static function getHashidConnection(Model $model)
    {
        return 'table.' . $model->table;
    }
    /**
     * @param Model $model
     * @return string
     */
    public static function getHashidColumn(Model $model)
    {
        return 'uid';
    }
    /**
     * @param Model $model
     * @return mixed
     */
    public static function getHashidEncodingValue(Model $model)
    {
        return $model->id;
    }
}
