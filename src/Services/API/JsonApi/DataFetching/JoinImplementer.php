<?php


namespace App\Services\API\JsonApi\DataFetching;


use App\Database\Entities\Metadata\Factory;
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
     * @var string
     */
    private $entityName;

    /**
     * JoinImplementer constructor.
     * @param string $query
     * @param ParameterBag $queryBag
     * @param string $entityName
     */
    public function __construct(string $query, ParameterBag $queryBag, string $entityName)
    {
        $this->query = $query;
        $this->queryBag = $queryBag;
        $this->entityName = $entityName;
    }

    public function join(): void
    {
        foreach ($this->orderingPreparation() as $order => $column) {
            switch ($column) {
                case NativeOrderImplementer::PRICE:
                    $this->priceOrdering($order, $column);
                    break;
                case NativeOrderImplementer::CPU_SOCKET:
                case NativeOrderImplementer::FORM_FACTOR:
                case NativeOrderImplementer::CHIPSET:
                    $this->generalOrderingWIthJoin($order, $column);
                    break;
                case NativeOrderImplementer::COLOR:
                    $this->colorOrdering($order, $column);
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
        $meta = Factory::create($this->entityName);
        if (!$meta) return;

        [$foreignKey, $tableName] = $meta->get($column);

        if (!$foreignKey || !$tableName) return;

        $sql = <<<SQL
left join (
      select min(price) as price, $foreignKey
      from (
          select *
          from $tableName
          order by date desc
      ) as j
group by $foreignKey
) as j on j.$foreignKey=a.id
SQL;

        $this->query .= " " . $sql;
    }

    private function generalOrderingWIthJoin($order, $column): void
    {
        $meta = Factory::create($this->entityName);
        if (!$meta) return;

        [$foreignKey, $tableName] = $meta->get($column);

        $sql = <<<SQL
left join $tableName as j on j.id = a.$foreignKey 
SQL;
        $this->query .= " " . $sql;

    }

    private function colorOrdering($order, $column): void
    {
        $meta = Factory::create($this->entityName);
        if (!$meta) return;

        [$foreignKey, $tableName] = $meta->get($column);

        $sql = <<<SQL
left join
(select mb.id, group_concat(c.name) as name
from $tableName as mc
         left join motherboards as mb on mc.$foreignKey = mb.id
         left join colors as c on c.id = mc.color_id
group by mb.id) as j on j.id = a.id
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