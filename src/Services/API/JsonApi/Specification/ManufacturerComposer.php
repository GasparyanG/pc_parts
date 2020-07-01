<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\Manufacturer;

class ManufacturerComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Manufacturer::class;
}