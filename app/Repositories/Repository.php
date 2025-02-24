<?php

/**
 * Base repository.
 */

namespace App\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model as Model;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class Repository
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * @var App
     */
    private $app;

   /**
    * @var \Illuminate\Database\Eloquent\Model
    */
    protected $model;

   /**
    * Create model.
    */
    public function __construct()
    {
        $this->app = new App();
        $this->makeModel();
    }

   /**
    * Specify Model class name
    *
    * @return string
    */
    abstract public function model();

   /**
    * Create model
    */
    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        $this->model = $model;
    }

    /**
     * Create new resource.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function sort($field, $order)
    {
        $this->model = $this->model->orderBy($field, $order);
        return $this;
    }

    public function get()
    {
        return $this->model->get();
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        $paginated = $this->model->paginate($perPage);
        $paginated->appends('limit', $perPage);
        return $paginated;
    }

    public function find($id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            logger($e->getMessage());
            throw $e;
        }
    }

    public function store(array $data)
    {
        return $this->model->create($data['data']['attributes']);
    }

    public function update(array $data, $id)
    {
        $model = $this->find($id);
        $model->fill($data['data']['attributes'])->save();
        return $model;
    }

    public function delete($id)
    {
        $this->find($id)->delete();
    }

    public function findBy($field, $value)
    {
        return $this->model->where($field, $value);
    }
}
