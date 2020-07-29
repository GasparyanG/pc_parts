<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\Memory;

class MemoryMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["memory_id", "memory_prices"],
        "color" => ["memory_id", "memories_colors"],
        "modules" => ["modules_id", "modules"],
        "cas_latency" => ["timing_id", "timings"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = Memory::class;
}