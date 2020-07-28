<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\PowerSupply;

class PSUMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["psu_id", "psu_prices"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = PowerSupply::class;
}