<?php

namespace Modules\Core\Repositories\Eloquent;

use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityUpdated;
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
     * @param array $where
     * @return mixed
     *
     */
    public function firstOrCreate(array $where)
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->firstOrCreate($where);
        $this->resetModel();

        event(new RepositoryEntityCreated($this, $model));

        return $this->parserResult($model);
    }

    /**
     * Find data by multiple fields and update or create if not exists.
     *
     * @param array $where
     * @param array $attributes
     * @return mixed
     */
    public function createOrUpdate(array $where, array $attributes)
    {
        $this->applyCriteria();
        $this->applyScope();

        $_skipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        $model = $this->model->firstOrCreate($where);
        $model->fill($attributes);
        $model->save();

        $this->skipPresenter($_skipPresenter);
        $this->resetModel();

        event(new RepositoryEntityUpdated($this, $model));

        return $this->parserResult($model);
    }
}
