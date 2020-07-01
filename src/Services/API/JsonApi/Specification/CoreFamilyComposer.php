<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CoreFamily;

class CoreFamilyComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CoreFamily::class;
}