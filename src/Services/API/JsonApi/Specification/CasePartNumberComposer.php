<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CasePartNumber;

class CasePartNumberComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CasePartNumber::class;
}