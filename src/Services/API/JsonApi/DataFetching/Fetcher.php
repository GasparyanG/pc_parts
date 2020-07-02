<?php


namespace App\Services\API\JsonApi\DataFetching;


use App\Database\Connection;
use App\Services\API\JsonApi\Specification\Links;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;

class Fetcher
{
    const ALIAS = 'a';

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
            ->select(self::ALIAS)
            ->from($this->entityName, self::ALIAS);
    }

    private function order(): void
    {
        $orderImp = new OrderImplementer($this->queryBuilder, $this->queryBag);
        $orderImp->order();
    }

    private function filter(): void
    {
        // TODO: implement filter method
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
        try {
            return $this->queryBuilder->getQuery()->getResult();
        } catch (\Exception $e) {
            // TODO: return exception to caller
            echo $e->getMessage() . "\n";
            return [];
        }
    }
}