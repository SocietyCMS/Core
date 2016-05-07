<?php

namespace Modules\Core\Repositories\Eloquent;

class ActivityRepository extends EloquentBaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'Modules\\Core\\Entities\\Activity';
    }

    /**
     * Take the latest records and group by date.
     *
     * @param int $amount
     * @return mixed
     */
    public function latestGroupedByDate($amount = 10)
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->select('*', \DB::raw('DATE_ADD(DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00"),INTERVAL IF(MINUTE(created_at) < 30, 0, 1) HOUR) AS grouped_created_at'), \DB::raw('count(*) as count_in_group'))
            ->latest()
            ->groupBy('grouped_created_at')
            ->with('subject')
            ->take($amount)
            ->get();
        $this->resetModel();

        return $this->parserResult($model);
    }
}