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
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function firstOrCreate(array $where);
}
