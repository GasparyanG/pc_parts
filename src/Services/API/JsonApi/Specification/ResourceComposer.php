<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Connection;
use App\Services\API\JsonApi\DataFetching\Fetcher;
use App\Services\API\JsonApi\ResourceHandler;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\ParameterBag;

abstract class ResourceComposer
{
    /**
     * @var null|string
     */
    protected static $entityName;

    /**
     * @var array
     */
    protected static $includedParams = [];

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

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(ResourceHandler $resourceHandler, ParameterBag $queryBag, int $id = null)
    {
        $this->em = Connection::getEntityManager();
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

    public function assemble(bool $staticIncluded = false): void
    {
        if ($staticIncluded) $this->prepareIncludedQueryParams();

        $resource = $this->buildResource($this->id);

        // Prepare $this->resource for callers.
        $resource->arrayRepresentation();
        $this->resource = $resource->getRepresentation();
    }

    public function assembleCollection(): void
    {
        // get entities
        $fetcher = new Fetcher(static::$entityName, $this->queryBag);
        $entities = $fetcher->getEntities();

        $fetcher = new Fetcher(static::$entityName, $this->queryBag);
        $links = new Links(static::$entityName, $this->queryBag, $fetcher->count());

        // there may be no entity at all
        if (!$entities) return;

        // add links
        $links->arrayRepresentation();
        $this->resource[Links::LINKS] = $links->getRepresentation();
        $this->resource[Resource::META] = $this->resourceHandler->meta();

        $data = [];
        foreach($entities as $entity) {
            $resource = $this->buildResource($entity->getId());
            $resource->arrayRepresentation();
            $data[] = $resource->getRepresentation();
        }

        // key mentioning
        $this->resource[Resource::DATA] = $data;
    }

    protected function buildResource(int $id): Resource
    {
        $resource = new Resource();

        // Build $resource object
        $resource->setAttributes($this->resourceHandler->attributes($id));
        $resource->setId($id);
        $resource->setType($this->em->getClassMetadata(static::$entityName)->getTableName());
        $resource->setRelationships($this->resourceHandler->relationships($id));
        $resource->setIncluded($this->resourceHandler->included($this->queryBag->get(Resource::INCLUDED), $id));
        $resource->setMeta($this->resourceHandler->meta());

        return $resource;
    }

    protected function prepareIncludedQueryParams(): void
    {
        $included = implode(",", static::$includedParams);

        $this->queryBag->set(Resource::INCLUDED, $included);
    }
}
