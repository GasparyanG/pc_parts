<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\Storage;

class StorageMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["storage_id", "storage_prices"],
        "form_factor" => ["storage_form_factor_id", "storage_form_factors"],
        "type" => ["storage_type_id", "storage_types"],
        "interface" => ["storage_interface_id", "storage_interfaces"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = Storage::class;
}