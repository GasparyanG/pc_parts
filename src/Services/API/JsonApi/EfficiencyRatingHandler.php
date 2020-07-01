<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\EfficiencyRating;

class EfficiencyRatingHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = EfficiencyRating::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}