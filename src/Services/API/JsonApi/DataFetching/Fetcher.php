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
        if (!$this->native()) {
            $this->select();
            $this->filter();
            $this->order();
            $this->limit();
            return $this->find();
        } else
            return $this->nativeQuery();
    }

    public function native(): bool
    {
        if ($this->nativeQueryValues()) return true;
        return false;
    }

    public function nativeQuery(): iterable
    {
        $sql = <<<SQL
select vc.* from video_cards vc
left join (
      select min(price) as price, gpu_id
      from (
          select *
          from gpu_prices
          order by date desc
      ) as a
group by gpu_id
) as a on a.gpu_id=vc.id
order by a.price desc;
SQL;

        $rsm = new ResultSetMappingBuilder($this->em);
        $rsm->addRootEntityFromClassMetadata("App\Database\Entities\VideoCard", "vc");

        $query = $this->em->CreateNativeQuery($sql, $rsm);
        return $query->getResult();
    }

    public function nativeQueryValues(): bool
    {
        foreach ($this->orderingPreparation() as $order => $column) {
            switch ($column) {
                case OrderImplementer::PRICE:
                    return true;
                default:
                    return false;
            }
        }

        return false;
    }

    private function orderingPreparation(): array
    {
        $explodedOrderParams = explode(',', $this->queryBag->get(OrderImplementer::ORDER));
        $orderingAssoc = [];

        if(isset($explodedOrderParams[0]) && !$explodedOrderParams[0]) return $orderingAssoc;

        foreach ($explodedOrderParams as $param)
            if ($param[0] === OrderImplementer::DESC_CHAR)
                $orderingAssoc[OrderImplementer::DESC] = ltrim($param, OrderImplementer::DESC_CHAR);
            else
                $orderingAssoc[OrderImplementer::ASC] = $param;

        return $orderingAssoc;
    }

    private function select(): void
    {
        $this->query .= "select " . self::ALIAS . ".* from "
            . $this->em->getClassMetadata($this->entityName)->getTableName()
            . " as " . self::ALIAS;
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
            echo $this->query;

            $rsm = new ResultSetMappingBuilder($this->em);
            $rsm->addRootEntityFromClassMetadata($this->entityName, self::ALIAS);

            $query = $this->em->CreateNativeQuery($this->query, $rsm);
            return $query->getResult();
        } catch (\Exception $e) {
            // TODO: return exception to caller
            echo $e->getMessage() . "\n";
            return [];
        }
    }
}