<?php namespace Modules\Core\Entities;

use Spatie\MediaLibrary\Media as SpatieMedia;
use Modules\Core\Traits\Entities\EloquentUuid;

class Media extends SpatieMedia {

    use EloquentUuid;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'core__media';

}