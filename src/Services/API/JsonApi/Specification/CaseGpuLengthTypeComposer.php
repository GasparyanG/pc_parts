<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CaseGpuLengthType;

class CaseGpuLengthTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CaseGpuLengthType::class;
}