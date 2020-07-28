<?php


namespace App\Services\API\JsonApi\DataFetching;


use Symfony\Component\HttpFoundation\ParameterBag;

class JoinImplementer
{
    /**
     * @var string
     */
    private $query;

    /**
     * @var ParameterBag
     */
    private $queryBag;

    /**
     * JoinImplementer constructor.
     * @param string $query
     * @param ParameterBag $queryBag
     */
    public function __construct(string $query, ParameterBag $queryBag)
    {
        $this->query = $query;
        $this->queryBag = $queryBag;
    }

    public function join(): void
    {
        foreach ($this->orderingPreparation() as $order => $column) {
            switch ($column) {
                case NativeOrderImplementer::PRICE:
                    $this->priceOrdering($order, $column);
                    break;
            }
        }
    }

    private function orderingPreparation(): array
    {
        $explodedOrderParams = explode(',', $this->queryBag->get(NativeOrderImplementer::ORDER));
        $orderingAssoc = [];

        if(isset($explodedOrderParams[0]) && !$explodedOrderParams[0]) return $orderingAssoc;

        foreach ($explodedOrderParams as $param)
            if ($param[0] === NativeOrderImplementer::DESC_CHAR)
                $orderingAssoc[NativeOrderImplementer::DESC] = ltrim($param, NativeOrderImplementer::DESC_CHAR);
            else
                $orderingAssoc[NativeOrderImplementer::ASC] = $param;

        return $orderingAssoc;
    }

    private function priceOrdering(string $order, string $column): void
    {
        $sql = <<<SQL
left join (
      select min(price) as price, gpu_id
      from (
          select *
          from gpu_prices
          order by date desc
      ) as j
group by gpu_id
) as j on j.gpu_id=a.id
SQL;

        $this->query .= " " . $sql;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }
}