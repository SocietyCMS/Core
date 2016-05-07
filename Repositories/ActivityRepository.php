<?php

namespace Modules\Core\Repositories;

/**
 * Interface UserRepository.
 */
interface ActivityRepository
{
    /**
     * Returns all the activities.
     *
     * @return object
     */
    public function all();

    /**
     * Create a activity resource.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * Deletes a activity.
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * Get lastest activities.
     * @return mixed
     */
    public function latest();

    /**
     * Get lastest activities grouped by date.
     * @return mixed
     */
    public function latestGrouped();
}
