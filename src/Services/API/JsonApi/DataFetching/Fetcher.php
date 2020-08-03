<?php


namespace App\Services\API\JsonApi\DataFetching;


use App\Database\Connection;
use App\Services\API\JsonApi\Specification\Links;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;

class Fetcher
{
    const ALIAS = 'a';
    const JOIN_ALIAS = 'j';

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

    /**
     * @var string
     */
    private $query;

    public function __construct(string $entityName, ParameterBag $queryBag)
    {
        $this->em = Connection::getEntityManager();
        $this->entityName = $entityName;
        $this->queryBag = $queryBag;

        $this->queryBuilder = $this->em->createQueryBuilder();
        $this->query = "";
    }

    public function getEntities(): iterable
    {
        $this->select();
        $this->joins();
        $this->filter();
        $this->order();
        $this->limit();
        return $this->find();
    }

    private function select(): void
    {
        $this->query .= "select " . self::ALIAS . ".* from "
            . $this->em->getClassMetadata($this->entityName)->getTableName()
            . " as " . self::ALIAS;
    }

    private function joins(): void
    {
        $joinImp = new JoinImplementer($this->query, $this->queryBag, $this->entityName);
        $joinImp->join();
        $this->query = $joinImp->getQuery();
    }

    private function order(): void
    {
        $orderImp = new NativeOrderImplementer($this->query, $this->queryBag);
        $orderImp->order();
        $this->query = $orderImp->getQuery();
    }

    private function filter(): void
    {
        $filterImp = new NativeFilterImplementer($this->query, $this->queryBag);
        $filterImp->filter();
        $this->query = $filterImp->getQuery();
    }

    private function limit(): void
    {
        $links = new Links($this->entityName, $this->queryBag);

        $this->query .= " limit ";
        if ($links->getOffset())
            $this->query .= $links->getOffset() . ',';
        $this->query .= $links->getSize();
    }

    private function find(): iterable
    {
        try {
            $rsm = new ResultSetMappingBuilder($this->em);
            $rsm->addRootEntityFromClassMetadata($this->entityName, self::ALIAS);

            $query = $this->em->CreateNativeQuery($this->query, $rsm);
//            echo $this->query;
            return $query->getResult();
        } catch (\Exception $e) {
            // TODO: return exception to caller
            echo $e->getMessage() . "\n";
            return [];
        }
    }
}