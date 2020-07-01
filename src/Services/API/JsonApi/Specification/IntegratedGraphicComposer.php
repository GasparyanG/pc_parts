<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\IntegratedGraphic;

class IntegratedGraphicComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = IntegratedGraphic::class;
}