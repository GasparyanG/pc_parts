<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\SidePanelWindowType;

class SidePanelWindowTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = SidePanelWindowType::class;
}