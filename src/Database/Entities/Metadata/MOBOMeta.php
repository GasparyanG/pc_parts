<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\Motherboard;

class MOBOMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["mobo_id", "mobo_prices"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = Motherboard::class;
}