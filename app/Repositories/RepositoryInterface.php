<?php

/**
 * Repository interface.
 */

namespace App\Repositories;

interface RepositoryInterface
{

    public function all();

    public function paginate($perPage = 15);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id);

    public function findBy($field, $value);
}
