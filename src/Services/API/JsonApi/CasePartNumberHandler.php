<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CasePartNumber;

class CasePartNumberHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CasePartNumber::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}