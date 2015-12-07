<?php

namespace Modules\Core\Repositories\Eloquent\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class OrderCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->orderBy('order', 'DESC');

        return $model;
    }
}
