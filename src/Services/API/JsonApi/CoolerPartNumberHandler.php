<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CoolerPartNumber;

class CoolerPartNumberHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CoolerPartNumber::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}