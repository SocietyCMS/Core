<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Entities\RelatesToUser;

/**
 * Class Activity.
 */
class Activity extends Model
{
    use RelatesToUser;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'core__activities';

    /**
     * @var array
     */
    protected $fillable = ['subject_id', 'subject_type', 'name', 'user_id', 'template', 'privacy'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }
}
