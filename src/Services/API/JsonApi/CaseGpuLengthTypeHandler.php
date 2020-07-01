<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CaseGpuLengthType;

class CaseGpuLengthTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CaseGpuLengthType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}