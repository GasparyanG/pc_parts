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
        $index = array_search($field, $this->fields);
        if (!$index) return null;
        return self::ALIAS . $index;
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