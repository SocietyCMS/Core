<?php

namespace Modules\Core\Entities;

use Modules\Core\Traits\Entities\EloquentUuid;
use Spatie\MediaLibrary\Media as SpatieMedia;

class Media extends SpatieMedia
{
    use EloquentUuid;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'core__media';
}
