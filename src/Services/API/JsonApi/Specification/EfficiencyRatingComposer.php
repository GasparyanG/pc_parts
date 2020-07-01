<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\EfficiencyRating;

class EfficiencyRatingComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = EfficiencyRating::class;
}