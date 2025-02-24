<?php

namespace App\Repositories\Organization;

use App\Models\Organization\Organization;
use App\Repositories\Repository;

/**
 * Organization repository
 */
class OrganizationRepository extends Repository
{
    /**
     * Count all organizations matching a name - even deleted ones!
     *
     * @param $name string
     * @return integer
     */
    public function getCountByName($name, $ignoreId = null): int
    {
        $query = $this->findBy('name', $name);
        if ($ignoreId) {
            $query = $query->where('id', '!=', $ignoreId);
        }
        return $query->get()->count();
    }

    /**
     * List organization with optional paging
     *
     * @param $filters
     * @return mixed
     */
    public function list($filters)
    {
        $query = $this->model;

        if (array_key_exists('order', $filters)) {
            $query = $query->orderBy($filters['order_by'], $filters['order']);
        }

        if (array_key_exists('page', $filters)) {
            return $query->paginate();
        }
        return $query->get();
    }

    /**
     * Create new organization.
     *
     * @param $data array
     * @return Organization
     */
    public function store(array $data): Organization
    {
        return $this->create([
            'name' => $data['data']['attributes']['name'],
            'budget' => $data['data']['attributes']['budget'] ?? 0,
            'facility_limit' => $data['data']['attributes']['facility_limit'],
        ]);
    }

    /**
     * Define model name.
     *
     * @return string
     */
    public function model(): string
    {
        return Organization::class;
    }
}
