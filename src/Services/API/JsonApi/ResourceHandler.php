<?php


namespace App\Services\API\JsonApi;


use App\Database\Connection;
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

    public function __construct()
    {
        $this->em = Connection::getEntityManager();
        $this->repo = $this->em->getRepository(static::$entityName);
    }

    /**
     * @param int $id
     * @return array
     */
    abstract public function attributes(int $id): array;

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