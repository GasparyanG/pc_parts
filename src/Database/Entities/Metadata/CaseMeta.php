<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\PcCase;

class CaseMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["case_id", "case_prices"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = PcCase::class;
}