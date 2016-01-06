<?php

namespace Modules\Core\Repositories\Eloquent;

use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class EloquentBaseRepository.
 */
abstract class EloquentBaseRepository extends BaseRepository implements CacheableInterface
{
    use CacheableRepository;
    /**
     * Find data by multiple fields or create if not exists.
     *
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function firstOrCreate(array $where)
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->firstOrCreate($where);
        $this->resetModel();

        return $this->parserResult($model);
    }
}
