<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\Module;

class ModuleComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Module::class;
}