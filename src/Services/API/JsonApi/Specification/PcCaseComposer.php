<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\PcCase;

class PcCaseComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PcCase::class;
}