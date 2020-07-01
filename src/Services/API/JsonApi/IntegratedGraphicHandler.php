<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\IntegratedGraphic;

class IntegratedGraphicHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = IntegratedGraphic::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}