<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\Usb;

class UsbHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Usb::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}