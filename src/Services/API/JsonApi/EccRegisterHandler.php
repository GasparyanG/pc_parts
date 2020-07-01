<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\EccRegister;

class EccRegisterHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = EccRegister::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}