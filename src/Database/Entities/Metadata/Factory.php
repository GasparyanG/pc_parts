<?php


namespace App\Database\Entities\Metadata;


class Factory
{
    private static $entities = [
        GPUMeta::class,
        CPUMeta::class,
        MemoryMeta::class
    ];

    public static function create(string $entityName): ?AbstractMeta
    {
        foreach (self::$entities as $entityMeta) {
            if ((new $entityMeta())->isUsed($entityName))
                return new $entityMeta();
        }

        return null;
    }
}