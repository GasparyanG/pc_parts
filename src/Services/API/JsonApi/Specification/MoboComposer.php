<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\Motherboard;

class MoboComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    protected static $entityName = Motherboard::class;
}