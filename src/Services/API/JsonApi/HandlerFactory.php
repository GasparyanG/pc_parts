<?php


namespace App\Services\API\JsonApi;


class HandlerFactory
{
    private static $handlerNames = [
        GPUHandler::class,
        CPUHandler::class,
        PSUHandler::class,
        MemoryHandler::class,
        StorageHandler::class,
        GpuImageHandler::class
    ];

    public static function create(string $entityName): ?ResourceHandler
    {
        foreach (self::$handlerNames as $handler)
            if ((new $handler())->isUsed($entityName))
                return new $handler();
        return null;
    }
}