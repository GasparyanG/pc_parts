<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\Usb;

class UsbComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Usb::class;
}