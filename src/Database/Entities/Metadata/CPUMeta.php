<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\Cpu;

class CPUMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["cpu_id", "cpu_prices"],
        "integrated_graphics" => ["integrated_graphic_id", "integrated_graphics"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = Cpu::class;
}