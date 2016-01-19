<?php

namespace Modules\Core\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BaseRepository.
 */
interface BaseRepository extends RepositoryInterface
{

    /**
     * Find data by multiple fields or create if not exists.
     *
     * @param array $where
     * @return mixed
     */
    public function firstOrCreate(array $where);

    /**
     * Find data by multiple fields and update or create if not exists.
     *
     * @param array $where
     * @param array $attributes
     * @return mixed
     */
    public function createOrUpdate(array $where, array $attributes);
}
