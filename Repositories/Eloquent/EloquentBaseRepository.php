<?php namespace Modules\Core\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class EloquentBaseRepository
 *
 * @package Modules\Core\Repositories\Eloquent
 */
abstract class EloquentBaseRepository extends BaseRepository
{

    /**
     * Find data by multiple fields or create if not exists
     *
     * @param $id
     * @param array $columns
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
