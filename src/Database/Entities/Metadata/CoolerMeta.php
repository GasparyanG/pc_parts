<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\Cooler;

class CoolerMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["cooler_id", "cooler_prices"],
        "color" => ["cooler_id", "coolers_colors"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = Cooler::class;
}