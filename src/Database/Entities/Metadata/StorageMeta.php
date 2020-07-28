<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\Storage;

class StorageMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["storage_id", "storage_prices"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = Storage::class;
}