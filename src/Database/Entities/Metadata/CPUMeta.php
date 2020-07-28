<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\Cpu;

class CPUMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["cpu_id", "cpu_prices"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = Cpu::class;
}