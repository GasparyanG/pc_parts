<?php


namespace App\Database\Entities\Metadata;


class Factory
{
    private static $entities = [
        GPUMeta::class
    ];

    public static function create(string $entityName): ?MetaInterface
    {
        foreach (self::$entities as $entityMeta) {
            if ((new $entityMeta())->isUsed($entityName))
                return new $entityMeta();
        }

        return null;
    }
}