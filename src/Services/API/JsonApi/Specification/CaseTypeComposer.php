<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CaseType;

class CaseTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CaseType::class;
}