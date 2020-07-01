<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\Timing;

class TimingHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Timing::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}