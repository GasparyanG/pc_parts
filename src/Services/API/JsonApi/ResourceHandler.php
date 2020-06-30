<?php


namespace App\Services\API\JsonApi;


use App\Database\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class ResourceHandler
{
    /**
     * @var null|string
     */
    public static $entityName = null;

    /**
     * @var EntityRepository
     */
    protected $repo;

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct()
    {
        $this->em = Connection::getEntityManager();
        $this->repo = $this->em->getRepository(static::$entityName);
    }

    /**
     * @param int $id
     * @return array
     */
    public function attributes(int $id): array
    {
        return $this->repo->findAsArray($id);
    }

    /**
     * @param int $id
     * @return array
     */
    abstract public function relationships(int $id): array;

    /**
     * @param string|null $relToInclude
     * @param int $id
     * @return array
     */
    abstract public function included(?string $relToInclude, int $id): array;
}