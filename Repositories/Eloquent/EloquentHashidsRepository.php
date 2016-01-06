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
    public function find($id, $columns = array('*'))
    {
        $id = Hashids::decode($id);

        if (empty($id)) {
            throw (new \Illuminate\Database\Eloquent\ModelNotFoundException())->setModel(get_class($this->model));
        }

        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->limit(1)->findOrFail($id, $columns)->first();
        $this->resetModel();

        return $this->parserResult($model);
    }
}
