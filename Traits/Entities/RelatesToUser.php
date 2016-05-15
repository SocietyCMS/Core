<?php

namespace Modules\Core\Traits\Entities;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Class EloquentUuid.
 */
trait RelatesToUser
{
    /**
     * User relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Modules\User\Entities\Entrust\EloquentUser', 'user_id')->withTrashed();
    }
}
