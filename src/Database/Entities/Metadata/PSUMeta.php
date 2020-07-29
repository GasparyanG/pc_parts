<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\PowerSupply;

class PSUMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["psu_id", "psu_prices"],
        "color" => ["power_supply_id", "psus_colors"],
        "form_factor" => ["psu_form_factor_id", "psu_form_factors"],
        "efficiency_rating" => ["efficiency_rating_id", "efficiency_ratings"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = PowerSupply::class;
}