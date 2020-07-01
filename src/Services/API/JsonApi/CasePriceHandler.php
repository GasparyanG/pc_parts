<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CasePrice;

class CasePriceHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CasePrice::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}