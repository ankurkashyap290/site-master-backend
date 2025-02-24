<?php

/**
 * Location repository.
 */

namespace App\Repositories\Location;

use App\Models\Location\Location;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

/**
 * Location Repository
 */
class LocationRepository extends Repository
{
    /**
     * List all location
     *
     * @param array $filters
     * @return
     */
    public function getLocationsOfFacility(array $filters)
    {
        $query = $this->model
            ->where('facility_id', (int)$filters['facility_id'])
            ->where('one_time', 0);

        if (array_key_exists('search_key', $filters) && !empty($filters['search_key'])) {
            $searchKey = $filters['search_key'];
            $query = $query->where(function ($query) use ($searchKey) {
                foreach ($this->model->getSearchableFields() as $column) {
                    $query = $query->orWhere($column, 'LIKE', "%$searchKey%");
                }
            });
        }
        if (array_key_exists('order_by', $filters)) {
            $query = $query->orderBy($filters['order_by'], $filters['order']);
        }

        if (array_key_exists('page', $filters)) {
            return $query->paginate();
        }
        return $query->get();
    }

    /**
     * Store all client from CSV file
     * @param string $csvFilePath
     * @return LocationRepository[]|Collection
     * @throws Throwable
     */
    public function import(string $csvFilePath)
    {
        $facility_id = auth()->user()->facility_id;
        $csvFile = fopen($csvFilePath, 'r');

        if (!!stristr(fgets($csvFile)[0], 'location name')) {
            rewind($csvFile);
        }

        while ($fields = fgetcsv($csvFile)) {
            if (is_null($fields[0])) {
                continue;
            }
            $location = new Location;
            $location->name = $fields[0];
            $location->phone = $fields[1];
            $location->address = $fields[2];
            $location->city = $fields[3];
            $location->state = $fields[4];
            $location->postcode = $fields[5];
            $location->facility_id = $facility_id;
            $location->saveOrFail();
        }
        fclose($csvFile);
        return $this->all();
    }

    /**
     * Define model name.
     *
     * @return string
     */
    public function model(): string
    {
        return Location::class;
    }
}
