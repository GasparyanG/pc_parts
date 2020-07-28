<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\VideoCard;

class GPUMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["gpu_id", "gpu_prices"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = VideoCard::class;
}