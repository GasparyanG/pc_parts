<?php


namespace App\Services\API\JsonApi\DataFetching;


use App\Database\Connection;
use Doctrine\ORM\EntityManager;
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
            switch ($column) {
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

        if (isset($explodedOrderParams[0]) && !$explodedOrderParams[0]) return $orderingAssoc;

        foreach ($explodedOrderParams as $param)
            if ($param[0] === self::DESC_CHAR)
                $orderingAssoc[self::DESC] = ltrim($param, self::DESC_CHAR);
            else
                $orderingAssoc[self::ASC] = $param;

        return $orderingAssoc;
    }
}