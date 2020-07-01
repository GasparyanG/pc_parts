<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\MDot2Type;

class MDot2TypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MDot2Type::class;
}