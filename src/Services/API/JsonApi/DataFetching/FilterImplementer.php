<?php


namespace App\Services\API\JsonApi\DataFetching;


use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;

class FilterImplementer
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
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @var ParameterBag
     */
    private $queryBag;

    /**
     * @var string|null
     */
    private $filterString = null;

    /**
     * @var FetcherHelper
     */
    private $fetcherHelper;

    /**
     * FilterImplementer constructor.
     * @param QueryBuilder $queryBuilder
     * @param ParameterBag $queryBag
     */
    public function __construct(QueryBuilder $queryBuilder, ParameterBag $queryBag)
    {
        $this->queryBuilder = $queryBuilder;
        $this->queryBag = $queryBag;

        // FetcherHelper preparation
        $this->fetcherHelper = new FetcherHelper();
        $this->fetcherHelper->prepareFieldsForJoin();

        $this->filterString = "";
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

        $this->queryBuilder->andWhere($this->filterString);
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
                    .= $this->fetcherHelper->alias($field) . ".$field "
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
}