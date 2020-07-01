<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CaseType;

class CaseTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CaseType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}