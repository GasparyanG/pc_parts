<?php


namespace App\Services\API\JsonApi\DataFetching;


use App\Database\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;

class OrderImplementer
{
    // keywords
    const ORDER = "order";
    const ASC = "ASC";
    const DESC = "DESC";
    const DESC_CHAR = '-';

    // fields to order
    const PRICE = "price";

    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @var ParameterBag
     */
    private $queryBag;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(QueryBuilder $queryBuilder, ParameterBag $queryBag)
    {
        $this->queryBuilder = $queryBuilder;
        $this->queryBag = $queryBag;
        $this->em = Connection::getEntityManager();
    }

    public function order(): void
    {
        foreach ($this->orderingPreparation() as $order => $column) {
            switch($column) {
                case self::PRICE:
                    $this->priceOrdering($order, $column);
                    break;
                default:
                    $this->queryBuilder->addOrderBy(Fetcher::ALIAS . '.' . $column, $order);
                    break;
            }
        }
    }

    private function orderingPreparation(): array
    {
        $explodedOrderParams = explode(',', $this->queryBag->get(self::ORDER));
        $orderingAssoc = [];

        if(isset($explodedOrderParams[0]) && !$explodedOrderParams[0]) return $orderingAssoc;

        foreach ($explodedOrderParams as $param)
            if ($param[0] === self::DESC_CHAR)
                $orderingAssoc[self::DESC] = ltrim($param, self::DESC_CHAR);
            else
                $orderingAssoc[self::ASC] = $param;

        return $orderingAssoc;
    }

    /*
     *   select vc.* from video_cards vc
     *   left join (
     *         select min(price) as price, gpu_id
     *         from (
     *             select *
     *             from gpu_prices
     *             order by date desc
     *         ) as a
     *    group by gpu_id
     *   ) as a on a.gpu_id=vc.id
     *   order by a.price desc;
     */
    private function priceOrdering(string $order, string $column): void
    {
//        $orderedPricesSubSelect = $this->em->createQueryBuilder()
//            ->select("g")
//            ->from("App\Database\Entities\GpuPrice", "g")
//            ->orderBy("g.$column");
//
//        $minPriceSubSelect = $this->em->createQueryBuilder()
//            ->select(
//                "min(c.$column) as price, IDENTITY(c.gpu) as gpu"
//                . " from App\Database\Entities\GpuPrice as c"
//                . " where c.id in (" . $orderedPricesSubSelect->getDQL() . ")"
//                . " group by gpu"
//            );
//
//        $this->queryBuilder
//            ->leftJoin(sprintf('(%s)',
//                $minPriceSubSelect->getDQL()), "g",
//                Join::WITH,
//                "g.gpu=" . Fetcher::ALIAS . ".id")
//            ->orderBy("g.$column", $order);

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
order by a.price;
SQL;

        $rsm = new ResultSetMappingBuilder($this->em);
        $rsm->addRootEntityFromClassMetadata("App\Database\Entities\VideoCard", "vc");

        $query = $this->em->CreateNativeQuery($sql, $rsm);

        $res = $query->getResult();
    }
}