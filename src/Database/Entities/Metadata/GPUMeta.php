<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\VideoCard;

class GPUMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["gpu_id", "gpu_prices"],
        "color" => ["video_card_id", "gpus_colors"],
        "chipset" => ["chipset_id", "chipsets"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = VideoCard::class;
}