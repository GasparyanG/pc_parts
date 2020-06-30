<?php


namespace App\Services\API\JsonApi\Specification;


use App\Services\API\JsonApi\ResourceHandler;
use Symfony\Component\HttpFoundation\ParameterBag;

abstract class ResourceComposer
{
    /**
     * @var ParameterBag
     */
    protected $queryBag;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var Resource[]
     */
    protected $resource = [];

    /**
     * @var ResourceHandler
     */
    protected $resourceHandler;

    public function __construct(ResourceHandler $resourceHandler, ParameterBag $queryBag, int $id = null)
    {
        $this->queryBag = $queryBag;
        $this->id = $id;
        $this->resourceHandler = $resourceHandler;
    }

    /**
     * @return Resource[]
     */
    public function getResource(): array
    {
        return $this->resource;
    }
}
