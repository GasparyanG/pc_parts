<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CoreFamily;

class CoreFamilyHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CoreFamily::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}