<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\Manufacturer;

class ManufacturerHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Manufacturer::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}