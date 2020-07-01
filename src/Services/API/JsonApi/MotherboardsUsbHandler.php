<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\MotherboardsUsb;

class MotherboardsUsbHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MotherboardsUsb::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}