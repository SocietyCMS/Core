<?php

namespace Modules\Core\Repositories\Eloquent;

use Modules\Core\Repositories\HashidsRepository;
use Vinkla\Hashids\Facades\Hashids;

abstract class EloquentHashidsRepository extends EloquentBaseRepository implements HashidsRepository
{
    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     * @return mixed
     */
    public function findByUid($id, $columns = array('*'))
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->where('uid', '=', $id)->firstOrFail($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }
}
