<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\ExpansionSlot;

class ExpansionSlotComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = ExpansionSlot::class;
}