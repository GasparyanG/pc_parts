<?php


namespace App\Services\API\JsonApi\DataFetching;


use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;

class OrderImplementer
{
    const ORDER = "order";
    const ASC = "ASC";
    const DESC = "DESC";
    const DESC_CHAR = '-';

    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @var ParameterBag
     */
    private $queryBag;

    public function __construct(QueryBuilder $queryBuilder, ParameterBag $queryBag)
    {
        $this->queryBuilder = $queryBuilder;
        $this->queryBag = $queryBag;
    }

    public function order(): void
    {
        foreach ($this->orderingPreparation() as $order => $column)
            $this->queryBuilder->addOrderBy(Fetcher::ALIAS . '.' . $column, $order);
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
}