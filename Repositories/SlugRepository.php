<?php

namespace Modules\Core\Repositories;

/**
 * Interface SlugRepository.
 */
interface SlugRepository extends BaseRepository
{
    /**
     * Find a resource by an given Slug.
     *
     * @param string $slug
     *
     * @return object
     */
    public function findBySlug($slug);

    /**
     * Generate a unique Slug for a given Title.
     *
     * @param string $title
     *
     * @return object
     */
    public function getSlugForTitle($title);
}
