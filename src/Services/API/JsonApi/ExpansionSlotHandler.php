<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\ExpansionSlot;

class ExpansionSlotHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = ExpansionSlot::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}