<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CaseBay;

class CaseBayHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CaseBay::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}