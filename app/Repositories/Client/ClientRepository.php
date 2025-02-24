<?php

namespace App\Repositories\Client;

use App\Models\Client\Client;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

/**
 * Client Repository
 */
class ClientRepository extends Repository
{
    /**
     * Return all Clients by Filter.
     *
     * @param array $filters
     * @return array
     */
    public function listByFilters(array $filters)
    {
        $query = $this->model;

        if (!empty($filters)) {
            if (array_key_exists('facility_id', $filters)) {
                $query = $query->where('facility_id', $filters['facility_id']);
            }
            if (array_key_exists('search_key', $filters) && !empty($filters['search_key'])) {
                $searchKey = $filters['search_key'];

                $query = $query->where(function ($query) use ($searchKey) {
                    foreach ($this->model->getSearchableFields() as $column) {
                        $query = $query->orWhere($column, 'LIKE', '%' . $searchKey . '%');
                    }
                });
            }
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
     * Store all client from CSV file
     *
     * @param $csvFilePath string
     * @return ClientRepository[]|Collection
     * @throws Throwable
     */
    public function import(string $csvFilePath)
    {
        $facility_id = auth()->user()->facility_id;
        $csvFile = fopen($csvFilePath, 'r');

        if (!!stristr(fgets($csvFile)[0], 'first name')) {
            rewind($csvFile);
        }

        while ($fields = fgetcsv($csvFile)) {
            if (is_null($fields[0])) {
                continue;
            }
            $client = new Client;
            $client->first_name = $fields[0];
            $client->middle_name = $fields[1];
            $client->last_name = $fields[2];
            $client->room_number = $fields[3];
            $client->responsible_party_email = $fields[4];
            $client->facility_id = $facility_id;
            $client->saveOrFail();
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
        return Client::class;
    }
}
