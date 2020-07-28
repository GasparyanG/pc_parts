<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\VideoCard;

class GPUMeta implements MetaInterface
{
    /**
     * Map table foreign key and table name with convenient name
     *
     * @var array nested
     */
    private $meta = [
        "price" => ["gpu_id", "gpu_prices"]
    ];

    protected $name = VideoCard::class;

    /**
     * {@inheritDoc}
     */
    public function get(string $key): array
    {
        return $this->meta[$key] ?? [null, null];
    }

    /**
     * {@inheritDoc}
     */
    public function isUsed(string $entityName) : bool
    {
        return $this->name === $entityName;
    }
}