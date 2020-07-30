<?php


namespace App\Services\API\JsonApi\DataFetching;


use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class FetcherHelper
{
    const ALIAS = 'j';

    /**
     * @var ParameterBag
     */
    private $queryBag;

    /**
     * Table fields based on which filtration and ordering is done.
     *
     * @var array
     */
    private $fields = [];

    private static $fieldsToJoin = [
        NativeOrderImplementer::PRICE,
        NativeOrderImplementer::CPU_SOCKET,
        NativeOrderImplementer::FORM_FACTOR,
        NativeOrderImplementer::COLOR,
        NativeOrderImplementer::CHIPSET,
        NativeOrderImplementer::INTEGRATED_GRAPHICS,
        NativeOrderImplementer::MODULES,
        NativeOrderImplementer::CAS_LATENCY,
        NativeOrderImplementer::TYPE,
        NativeOrderImplementer::INTERFACE,
        NativeOrderImplementer::EFFICIENCY_RATING,
        NativeOrderImplementer::SIDE_PANEL_WINDOW_TYPE
    ];

    public function __construct()
    {
        $request = Request::createFromGlobals();
        $this->queryBag = $request->query;
    }

    /**
     * Prepares fields for join based on query params of request.
     */
    public function prepareFieldsForJoin(): void
    {
        $this->order();
        $this->filter();
    }

    /**
     * Generates alias for table base on given field.
     *
     * @param string $field
     * @return string|null
     */
    public function alias(string $field): ?string
    {
        // Make sure, that field do not belong to main table (i.e. it is from joined table)
        if (!in_array($field, self::$fieldsToJoin))
            return Fetcher::ALIAS;

        $index = array_search($field, $this->fields);
        if ($index === false) return null;
        return self::ALIAS . $index;
    }

    public function actualFieldName(string $field): string
    {
        return NativeOrderImplementer::$actualFieldNames[$field] ?? $field;
    }

    private function order(): void
    {
        $orderQueryParam = $this->queryBag->get(OrderImplementer::ORDER);
        if (!$orderQueryParam) return;

        $explodedParams = explode(',', $orderQueryParam);
        foreach ($explodedParams as $param) {
            // sanitize
            if ($param[0] == OrderImplementer::DESC_CHAR)
                $this->addField(substr($param, 1));
            else
                $this->addField($param);
        }

    }

    private function filter(): void
    {
        $filterQueryParam = $this->queryBag->get(FilterImplementer::FILTER);
        if (!$filterQueryParam) return;

        $this->extractFilterFields($filterQueryParam);
    }

    private function extractFilterFields(array $filterQueryParam): void
    {
        foreach ($filterQueryParam as $field => $details)
            if ($field == FilterImplementer::AND || $field == FilterImplementer::OR)
                $this->extractFilterFields($details);
            else
                $this->addField($field);
    }

    private function addField(string $field): void
    {
        // Make sure that field is not duplicated.
        if (!in_array($field, $this->fields))
            $this->fields[] = $field;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }
}