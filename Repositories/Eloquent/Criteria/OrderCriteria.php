<?php

namespace Modules\Core\Repositories\Eloquent\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OrderCriteria
 * @package Modules\Core\Repositories\Eloquent\Criteria
 */
class OrderCriteria implements CriteriaInterface
{
    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->orderBy('order', 'DESC');

        return $model;
    }
}
