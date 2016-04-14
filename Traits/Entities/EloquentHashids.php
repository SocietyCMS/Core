<?php

namespace Modules\Core\Traits\Entities;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EloquentHashids.
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
        static::creating(function (Model $model) {
            $model->{static::getHashidColumn($model)} = uniqid();
        });

        static::created(function (Model $model) {
            $model->{static::getHashidColumn($model)} = (new Hashids(
                static::getHashidConnection($model),
                static::getHashidLength($model)))
                ->encode(static::getHashidEncodingValue($model));
            $model->save();
        });
    }

    /**
     * @param Model $model
     *
     * @return string
     */
    public static function getHashidConnection(Model $model)
    {
        return 'table.'.$model->table;
    }

    /**
     * @param Model $model
     *
     * @return string
     */
    public static function getHashidLength(Model $model)
    {
        return 4;
    }

    /**
     * @param Model $model
     *
     * @return string
     */
    public static function getHashidColumn(Model $model)
    {
        return 'uid';
    }

    /**
     * @param Model $model
     *
     * @return mixed
     */
    public static function getHashidEncodingValue(Model $model)
    {
        return $model->id;
    }
}
