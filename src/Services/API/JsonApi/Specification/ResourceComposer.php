<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Connection;
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

    public function assemble(): void
    {
        $resource = $this->buildResource($this->id);

        // Prepare $this->resource for callers.
        $resource->arrayRepresentation();
        $this->resource = $resource->getRepresentation();
    }

    public function assembleCollection(): void
    {
        // get entities
        $links = new Links(static::$entityName, $this->queryBag);
        $entities = $this->em->getRepository(static::$entityName)
            ->findViaPagination($links->getOffset(), $links->getSize());


        // there may be no entity at all
        if (!$entities) return;

        foreach($entities as $entity) {
            $resource = $this->buildResource($entity->getId());
            $resource->arrayRepresentation();
            $this->resource[] = $resource->getRepresentation();
        }
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

        return $resource;
    }
}
