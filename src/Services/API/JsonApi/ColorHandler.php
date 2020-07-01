<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\Color;

class ColorHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Color::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}