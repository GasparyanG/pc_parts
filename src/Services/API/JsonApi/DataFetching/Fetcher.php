<?php


namespace App\Services\API\JsonApi\DataFetching;


use App\Database\Connection;
use App\Services\API\JsonApi\Specification\Links;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;

class Fetcher
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var string
     */
    private $entityName;

    /**
     * @var ParameterBag
     */
    private $queryBag;

    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    public function __construct(string $entityName, ParameterBag $queryBag)
    {
        $this->em = Connection::getEntityManager();
        $this->entityName = $entityName;
        $this->queryBag = $queryBag;

        $this->queryBuilder = $this->em->createQueryBuilder();
    }

    public function getEntities(): iterable
    {
        $this->select();
        $this->order();
        $this->filter();
        $this->limit();
        return $this->find();
    }

    private function select(): void
    {
        $this->queryBuilder
            ->select('c')
            ->from($this->entityName, 'c');
    }

    private function order(): void
    {

    }

    private function filter(): void
    {

    }

    private function limit(): void
    {
        $links = new Links($this->entityName, $this->queryBag);

        $this->queryBuilder
            ->setFirstResult($links->getOffset())
            ->setMaxResults($links->getSize());
    }

    private function find(): iterable
    {
        return $this->queryBuilder->getQuery()->getResult();
    }
}