<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\Module;

class ModuleHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Module::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}