<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\PowerSupply;

class PSUComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    protected static $entityName = PowerSupply::class;

    /**
     * {@inheritDoc}
     */
    protected static $includedParams = [
        "psu_images",
        "psu_part_numbers",
        "colors",
        "psu_connectors",
        "manufacturers",
        "psu_form_factors",
        "efficiency_ratings",
        "psu_prices"
    ];
}