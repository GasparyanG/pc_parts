<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\PcCase;

class CaseMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["case_id", "case_prices"],
        "color" => ["case_id", "cases_colors"],
        "type" => ["case_type_id", "case_types"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = PcCase::class;
}