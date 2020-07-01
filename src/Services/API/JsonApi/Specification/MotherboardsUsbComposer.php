<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\MotherboardsUsb;

class MotherboardsUsbComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MotherboardsUsb::class;
}