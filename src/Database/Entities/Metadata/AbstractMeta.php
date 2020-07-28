<?php


namespace App\Database\Entities\Metadata;


abstract class AbstractMeta implements MetaInterface
{
    /**
     * Map table foreign key and table name with convenient name
     *
     * @var array nested
     */
    protected $meta = [];

    /**
     * @var string|null
     */
    protected $name = null;

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