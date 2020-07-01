<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\Timing;

class TimingComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Timing::class;
}