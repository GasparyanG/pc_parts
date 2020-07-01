<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\MoboPrice;

class MoboPriceHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MoboPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}