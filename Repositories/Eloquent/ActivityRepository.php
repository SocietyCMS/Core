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

        if(!config('repository.cache.enabled', true) || $this->isSkippedCache()) {
            return $this->latestGroupedByDateSkippingCache($amount);
        }

        $key = $this->getCacheKey('latestGroupedByDate', func_get_args());

        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($amount) {
            return $this->latestGroupedByDateSkippingCache($amount);
        });

        return $value;
    }

    /**
     * Take the latest records and group by date.
     *
     * @param int $amount
     * @return mixed
     */
    protected function latestGroupedByDateSkippingCache($amount = 10)
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->select('*', \DB::raw('CONCAT(DATE_ADD(DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00"),INTERVAL IF(MINUTE(created_at) < 30, 0, 1) HOUR), "-", subject_id) AS grouped_created_at'), \DB::raw('count(*) as count_in_group'))
            ->orderby('created_at', 'desc')
            ->groupBy('grouped_created_at')
            ->with('subject')
            ->take($amount)
            ->get();
        $this->resetModel();

        return $this->parserResult($model);
    }
}
