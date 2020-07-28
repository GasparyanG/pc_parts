<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\Cooler;

class CoolerMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["cooler_id", "cooler_prices"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = Cooler::class;
}