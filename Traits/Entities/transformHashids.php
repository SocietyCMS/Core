<?php

namespace Modules\Core\Traits\Entities;

/**
 * Class useHashids
 * @package Modules\Core\Traits\Entities
 */
trait transformHashids
{

    /**
     * Transform id to hashid
     * @param $value
     * @return mixed
     */
    public function getIdAttribute($value)
    {
        return Hashids::encode($value);
    }
}
