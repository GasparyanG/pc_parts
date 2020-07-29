<?php


namespace App\Services\API\JsonApi\DataFetching;


use App\Database\Connection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\ParameterBag;

class NativeOrderImplementer
{
    // keywords
    const ORDER = "order";
    const ASC = "ASC";
    const DESC = "DESC";
    const DESC_CHAR = '-';

    // fields to order
    const PRICE = "price";
    const CPU_SOCKET = "cpu_socket";
    const FORM_FACTOR = "form_factor";

    /**
     * @var string
     */
    private $query;

    /**
     * @var ParameterBag
     */
    private $queryBag;

    /**
     * @var EntityManager
     */
    private $em;

    private static $actualFieldNames = [
        self::CPU_SOCKET => "type",
        self::FORM_FACTOR => "type"
    ];

    public function __construct(string $query, ParameterBag $queryBag)
    {
        $this->query = $query;
        $this->queryBag = $queryBag;
        $this->em = Connection::getEntityManager();
    }

    public function order(): void
    {
        if ($this->orderingPreparation()) {

            $this->query .= " order by ";

            foreach ($this->orderingPreparation() as $order => $column) {
                switch($column) {
                    case self::PRICE:
                    case self::FORM_FACTOR:
                    case self::CPU_SOCKET:
                    {
                        $column = self::$actualFieldNames[$column] ?? $column;
                        $this->query .= Fetcher::JOIN_ALIAS . '.' . $column . ' ' . $order;
                        break;
                    }
                    default:
                        $this->query .= Fetcher::ALIAS . '.' . $column . ' ' . $order;
                        break;
                }
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

    private function orderingContainsJoin(): bool
    {
        // Add case if field is being ordered via join
        foreach ($this->orderingPreparation() as $order => $column) {
            switch ($column) {
                case self::PRICE:
                    return true;
            }
        }

        return false;
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