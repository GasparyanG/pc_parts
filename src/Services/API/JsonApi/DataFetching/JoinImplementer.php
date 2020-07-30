<?php


namespace App\Services\API\JsonApi\DataFetching;


use App\Database\Connection;
use App\Database\Entities\Metadata\Factory;
use App\Database\Repositories\ColorRepository;
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
     * @var FetcherHelper
     */
    private $fetcherHelper;

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

        // prepare fetcher helper
        $this->fetcherHelper = new FetcherHelper();
        $this->fetcherHelper->prepareFieldsForJoin();
    }

    public function join(): void
    {
        foreach ($this->fetcherHelper->getFields() as $column) {
            switch ($column) {
                case NativeOrderImplementer::PRICE:
                    $this->priceOrdering($column);
                    break;
                case NativeOrderImplementer::CPU_SOCKET:
                case NativeOrderImplementer::FORM_FACTOR:
                case NativeOrderImplementer::CHIPSET:
                case NativeOrderImplementer::INTEGRATED_GRAPHICS:
                case NativeOrderImplementer::CAS_LATENCY:
                case NativeOrderImplementer::TYPE:
                case NativeOrderImplementer::INTERFACE:
                case NativeOrderImplementer::EFFICIENCY_RATING:
                case NativeOrderImplementer::SIDE_PANEL_WINDOW_TYPE:
                    $this->generalOrderingWIthJoin($column);
                    break;
                case NativeOrderImplementer::COLOR:
                    $this->colorOrdering($column);
                    break;
                case NativeOrderImplementer::MODULES:
                    $this->modulesOrdering($column);
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

    private function priceOrdering(string $column): void
    {
        $meta = Factory::create($this->entityName);
        if (!$meta) return;

        [$foreignKey, $tableName] = $meta->get($column);

        if (!$foreignKey || !$tableName) return;

        $alias = $this->fetcherHelper->alias($column);

        $sql = <<<SQL
left join (
      select min(price) as price, $foreignKey
      from (
          select *
          from $tableName
          order by date desc
      ) as j
group by $foreignKey
) as $alias on $alias.$foreignKey=a.id
SQL;

        $this->query .= " " . $sql;
    }

    private function generalOrderingWIthJoin($column): void
    {
        $meta = Factory::create($this->entityName);
        if (!$meta) return;

        [$foreignKey, $tableName] = $meta->get($column);
        $alias = $this->fetcherHelper->alias($column);

        $sql = <<<SQL
left join $tableName as $alias on $alias.id = a.$foreignKey 
SQL;
        $this->query .= " " . $sql;

    }

    private function colorOrdering($column): void
    {
        $meta = Factory::create($this->entityName);
        if (!$meta) return;

        // table name
        $em = Connection::getEntityManager();
        $mainTableName = $em->getClassMetadata($this->entityName)->getTableName();

        [$foreignKey, $tableName] = $meta->get($column);

        $alias = $this->fetcherHelper->alias($column);
        $colorSeparator = ColorRepository::COLOR_SEPARATOR;

        $sql = <<<SQL
left join
(select mb.id, group_concat(distinct c.name order by c.name separator $colorSeparator) as name
from $tableName as mc
         left join $mainTableName as mb on mc.$foreignKey = mb.id
         left join colors as c on c.id = mc.color_id
group by mb.id) as $alias on $alias.id = a.id
SQL;

        $this->query .= " " . $sql;

    }

    private function modulesOrdering($column): void
    {
        $meta = Factory::create($this->entityName);
        if (!$meta) return;

        [$foreignKey, $tableName] = $meta->get($column);

        $alias = $this->fetcherHelper->alias($column);

        $sql = <<<SQL
left join (select amount*capacity as total, id from $tableName) as $alias on $alias.id=a.$foreignKey
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