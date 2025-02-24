<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Repository;

/**
 * User Repository
 */
class UserRepository extends Repository
{
    /**
     * Return all Users by Filter.
     *
     * array['role_ids'|'organization_id'|'facility_id'|'order_by'|'order'] array|integer|string|null
     * @param array (see above) $filters
     * @return array
     */
    public function listByFilters(array $filters)
    {
        $query = $this->model;
        if (!empty($filters['organization_id'])) {
            $query = $query->where('organization_id', $filters['organization_id']);
        }
        if (!empty($filters['facility_id'])) {
            $query = $query->where('facility_id', $filters['facility_id']);
        }
        if (!empty($filters['role_ids'])) {
            $query = $query->whereIn('role_id', explode(',', $filters['role_ids']));
        }
        if (array_key_exists('order_by', $filters)) {
            $query = $query->orderBy($filters['order_by'], strtoupper($filters['order']));
        }

        if (array_key_exists('page', $filters)) {
            return $query->paginate();
        }
        return $query->get();
    }

    /**
     * Count Users by email.
     *
     * @param $email string
     * @return integer
     */
    public function getCountByEmail($email): int
    {
        return $this->findBy('email', $email)->where('deleted_at', null)->withoutGlobalScopes()->get()->count();
    }

    /**
     * Create new User.
     *
     * @param $data array
     * @return User
     */
    public function store(array $data): User
    {
        return $this->create([
            'first_name' => $data['data']['attributes']['first_name'],
            'middle_name' => $data['data']['attributes']['middle_name'],
            'last_name' => $data['data']['attributes']['last_name'],
            'email' => $data['data']['attributes']['email'],
            'phone' => $data['data']['attributes']['phone'] ?? null,
            'role_id' => $data['data']['attributes']['role_id'],
            'color_id' => $data['data']['attributes']['color_id'] ?? null,
            'organization_id' => $data['data']['attributes']['organization']['id'],
            'facility_id' => $data['data']['attributes']['facility']['id'],
        ]);
    }

    /**
     * Define model name.
     *
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }
}
