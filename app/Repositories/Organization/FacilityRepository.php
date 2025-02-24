<?php

namespace App\Repositories\Organization;

use App\Exceptions\FacilityLimitException;
use App\Models\Organization\Organization;
use App\Models\Organization\Facility;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class FacilityRepository extends Repository
{
    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters)
    {
        $user = auth()->user();
        $query = $this->model;
        if ($user->role_id == Config::get('roles')['Super Admin']) {
            $query = $query->withoutGlobalScopes();
        }

        if (array_key_exists('order', $filters)) {
            $query = $query->orderBy($filters['order_by'], $filters['order']);
        }

        if (array_key_exists('page', $filters)) {
            return $query->paginate();
        }
        return $query->get();
    }

    /**
     * Count all facilities matching a name - even deleted ones!
     *
     * @param $name string
     * @param null|integer $ignoreId
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
     * Create new Facility.
     *
     * @param $data array
     * @return Facility|Model
     * @throws FacilityLimitException
     */
    public function store(array $data)
    {
        $organization = Organization::find($data['data']['attributes']['organization_id']);
        if ($organization->facilities()->count() >= $organization->facility_limit) {
            throw new FacilityLimitException('
                Journey Application appreciates the opportunity to serve your organization.
                However, it appears you have reached your maximum locations per your licensure
                agreement. Please contact us at info@journeytransportation.com if you feel this
                is an error or if you wish to expand your capacity.
            ');
        }

        return $this
            ->create([
                'name' => $data['data']['attributes']['name'],
                'budget' => $data['data']['attributes']['budget'] ?? 0,
                'organization_id' => $data['data']['attributes']['organization_id'],
                'timezone' => $data['data']['attributes']['timezone'],
            ]);
    }

    /**
     * Define model name.
     *
     * @return string
     */
    public function model(): string
    {
        return Facility::class;
    }
}
