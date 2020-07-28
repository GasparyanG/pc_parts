<?php


namespace App\Services\API\JsonApi\DataFetching;


use App\Database\Connection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\ParameterBag;

class NativeFilterImplementer
{
    const FILTER = "filter";
    const AND = "and";
    const OR = "or";
    const IN = "IN";
    const BETWEEN = "BETWEEN";

    private static $operators = [
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'e' => '=',
        'ne' => "!=",
        'in' => 'IN',
        'nin' => 'NOT IN',
        'isn' => 'IS NOT',
        'is' => 'IS',
        'between' => "BETWEEN"
    ];

    private static $conjunction = [
        self::AND, self::OR
    ];

    /**
     * @var string
     */
    private $query;


    /**
     * @var ParameterBag
     */
    private $queryBag;

    /**
     * @var string|null
     */
    private $filterString = null;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * FilterImplementer constructor.
     * @param string $query
     * @param ParameterBag $queryBag
     */
    public function __construct(string $query, ParameterBag $queryBag)
    {
        $this->query = $query;
        $this->queryBag = $queryBag;

        $this->filterString = "";
        $this->em = Connection::getEntityManager();
    }

    public function filter(): void
    {
        $filterParams = $this->queryBag->get(self::FILTER);
        // user may not provide any filter options
        if (!$filterParams) return;

        foreach ($filterParams as $key => $value)
            if (in_array($key, self::$conjunction))
                $this->combination($key, $value, "withConjunction", self::AND, false);
            else
                $this->combination($key, $value, "filterField", self::AND, false);

        if ($this->filterString)
            $this->query .= " where " . $this->filterString;
    }

    private function withConjunction(string $cnj, array $expression): void
    {
        foreach($expression as $key => $value)
            if (in_array($key, self::$conjunction))
                $this->combination($key, $value, "withConjunction", $cnj, false);
            else
                $this->combination($key, $value, "filterField", $cnj, true);
    }

    private function filterField(string $field, array $expression, string $cnj = null): void
    {
        $cycle = 0;
        foreach ($expression as $key => $value) {
            if (in_array($key, self::$conjunction))
                $this->withConjunction($key, $value);
            else
                if ($cycle === count($expression) - 1) $cnj = "";
            $this->filterString
                .= Fetcher::ALIAS . ".$field "
                . self::$operators[$key]
                . $this->preparedValue($key, $value)
                . $cnj . " ";
            ++$cycle;
        }
    }

    private function combination(
        $key,
        $value,
        string $methodName,
        string $cnj,
        bool $isCnj)
    {
        if ($this->isValidForConjunction())
            $this->filterString .= " $cnj ";
        $this->filterString .= "(";
        if ($isCnj)
            $this->$methodName($key, $value, $cnj);
        else
            $this->$methodName($key, $value);
        $this->filterString .= ")";
    }

    private function preparedValue(string $key, string $value): string
    {
        if (self::$operators[$key] === self::IN) $value = "($value)";
        else if (self::$operators[$key] === self::BETWEEN) {
            [$start, $end] = explode(',', $value);
            $value = " $start " . self::AND . " $end";
        }

        // keep distance
        return " $value ";
    }

    private function isValidForConjunction(): bool
    {
        if (!$this->filterString) return false;
        $pattern = '~(.+)?\(\s*$~i';
        return !preg_match($pattern, $this->filterString);
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