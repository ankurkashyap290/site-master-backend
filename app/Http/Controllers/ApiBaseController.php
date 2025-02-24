<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Transformers\Fractal;
use App\Transformers\TransformerInterface;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Response;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class ApiBaseController extends Controller
{
    /**
     * @var \App\Transformers\Fractal
     */
    protected $fractal;

    /**
     * @var \League\Fractal\TransformerAbstract
     */
    protected $transformer;

    /**
     * @var \App\Repositories\Repository
     */
    protected $repository;

    /**
     * Create a new ApiBaseController instance.
     */
    public function __construct()
    {
        $this->fractal = new Fractal();
        if ($this->getRepository()) {
            $this->repository = app()->make($this->getRepository());
        }

        $this->setTransformer($this->getTransformerType());
    }

    /**
     * Return with one resource item.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param integer|null $status
     * @return \Illuminate\Http\Response
     */
    protected function item($resource, $status = Response::HTTP_OK): Response
    {
        $response = $this->fractal->item($resource, $this->transformer, $this->transformer->getResourceKey());
        return $this->response($response, $status);
    }

    /**
     * Return with one resource item.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param integer|null $status
     * @return \Illuminate\Http\Response
     */
    protected function null($status = Response::HTTP_OK): Response
    {
        $response = $this->fractal->null();
        return $this->response($response, $status);
    }

    /**
     * Return with multiple resource items.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param integer|null $status
     * @return \Illuminate\Http\Response
     */
    protected function collection($resource, $status = Response::HTTP_OK): Response
    {
        $response = $this->fractal->collection($resource, $this->transformer, $this->transformer->getResourceKey());
        return $this->response($response, $status);
    }

    /**
     * Return with paginated resource items.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param integer|null $status
     * @return \Illuminate\Http\Response
     */
    protected function pagination($resource, $status = Response::HTTP_OK): Response
    {
        $response = $this->fractal->pagination($resource, $this->transformer, $this->transformer->getResourceKey());
        return $this->response($response, $status);
    }

    /**
     * Set transformer.
     *
     * @param string $transformer
     */
    protected function setTransformer($transformer)
    {
        $transformerClass = $transformer ?? 'App\Transformers\BaseTransformer';
        $this->transformer = app()->make($transformerClass);
    }

    /**
     * Json response.
     *
     * @param $data string
     * @param $status integer
     * @return Illuminate\Http\Response
     */
    protected function response($data, $status): Response
    {
        return response($data, $status)->header('Content-Type', 'application/json');
    }

    /**
     * Get transformer class.
     *
     * @return string
     */
    protected function getTransformerType(): ?string
    {
        return null;
    }

    /**
     * Get repository class.
     *
     * @return string
     */
    protected function getRepository(): ?string
    {
        return null;
    }
}
