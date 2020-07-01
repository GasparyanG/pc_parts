<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\MotherboardPartNumber;

class MotherboardPartNumberHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MotherboardPartNumber::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}