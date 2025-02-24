<?php

/**
 * Location repository.
 */

namespace App\Repositories\ETC;

use App\Models\ETC\ExternalTransportationCompany;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;

class ETCRepository extends Repository
{
    /**
     * List all location
     *
     * @param array $filters
     * @return Collection
     */
    public function getETCByFacility(array $filters)
    {
        $query = $this->model->where('facility_id', (int)$filters['facility_id']);

        if (array_key_exists('order', $filters)) {
            $query = $query->orderBy($filters['order_by'], $filters['order']);
        }

        if (array_key_exists('page', $filters)) {
            return $query->paginate();
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
        return ExternalTransportationCompany::class;
    }
}
