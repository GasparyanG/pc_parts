<?php


namespace App\Services\API\JsonApi\Specification;


use App\Services\API\JsonApi\ResourceHandler;
use Symfony\Component\HttpFoundation\ParameterBag;

abstract class ResourceComposer
{
    /**
     * @var null|string
     */
    protected static $tableName;

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

    public function assemble(): void
    {
        $resource = new Resource();

        // Build $resource object
        $resource->setAttributes($this->resourceHandler->attributes($this->id));
        $resource->setId($this->id);
        $resource->setType(static::$tableName);
        $resource->setRelationships($this->resourceHandler->relationships($this->id));
        $resource->setIncluded($this->resourceHandler->included($this->queryBag->get(Resource::INCLUDED), $this->id));

        // Prepare $this->resource for callers.
        $resource->arrayRepresentation();
        $this->resource = $resource->getRepresentation();
    }
}
