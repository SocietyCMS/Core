<?php

namespace Modules\Core\Repositories;

/**
 * Interface SlugRepository.
 */
interface HashidsRepository extends BaseRepository
{
    /**
     * Find a resource by an given Uid.
     *
     * @param $id
     * @param array $columns
     * @return object
     *
     */
    public function findByUid($id, $columns = ['*']);
}
