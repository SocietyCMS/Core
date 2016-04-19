<?php

namespace Modules\Core\Repositories\Eloquent;

use Illuminate\Support\Str;
use Modules\Core\Repositories\SlugRepository;

/**
 * Class EloquentSlugRepository
 * @package Modules\Core\Repositories\Eloquent
 */
abstract class EloquentSlugRepository extends EloquentBaseRepository implements SlugRepository
{
    /**
     * Find a resource by an given Slug.
     *
     * @param string $slug
     *
     * @return object
     */
    public function findBySlug($slug)
    {
        return $this->findWhere(['slug' => $slug])->first();
    }

    /**
     * Update a entity in repository by id.
     *
     * @param array $attributes
     * @param $id
     *
     * @throws ValidatorException
     *
     * @return mixed
     */
    public function updateBySlug(array $attributes, $slug)
    {
        $album = $this->findBySlug($slug);

        return $this->update($attributes, $album->id);
    }

    /**
     * Update a entity in repository by id.
     *
     * @param array $attributes
     * @param $id
     *
     * @throws ValidatorException
     *
     * @return mixed
     */
    public function deleteBySlug($slug)
    {
        $album = $this->findBySlug($slug);

        return $this->delete($album->id);
    }

    /**
     * Generate a unique Slug for a given Title.
     *
     * @param string $title
     *
     * @return object
     */
    public function getSlugForTitle($title)
    {
        $slug = Str::slug($title);
        $latestSlug = $this->model->whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")->latest()->value('slug');

        if ($latestSlug) {
            $pieces = explode('-', $latestSlug);
            $number = end($pieces);

            return $slug.'-'.($number + 1);
        }

        return $slug;
    }
}
