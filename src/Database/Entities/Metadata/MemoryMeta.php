<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\Memory;

class MemoryMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["memory_id", "memory_prices"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = Memory::class;
}