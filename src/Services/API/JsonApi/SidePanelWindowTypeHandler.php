<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\SidePanelWindowType;

class SidePanelWindowTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = SidePanelWindowType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}