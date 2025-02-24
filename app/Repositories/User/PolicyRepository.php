<?php

namespace App\Repositories\User;

use App\Models\Policy;
use App\Repositories\Repository;

/**
 * Policy Repository
 */
class PolicyRepository extends Repository
{
    /**
     * Return all Policies by filter.
     *
     * @param array $filters
     * @return array
     */
    public function listByFilters(array $filters)
    {
        $query = $this->model;
        if (!empty($filters['facility_id'])) {
            $query = $query->where('facility_id', $filters['facility_id']);
        }
        if (!empty($filters['role_id'])) {
            $query = $query->where('role_id', $filters['role_id']);
        }
        return $query->get();
    }

    /**
     * Define model name.
     *
     * @return string
     */
    public function model(): string
    {
        return Policy::class;
    }
}
