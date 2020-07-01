<?php


namespace App\Services\API\JsonApi;


class HandlerFactory
{
    public static $handlerNames = [
        GPUHandler::class,
        CPUHandler::class,
        PSUHandler::class,
        MemoryHandler::class,
        StorageHandler::class,
        GpuImageHandler::class,
        CpuImageHandler::class,
        CpuImageHandler::class,
        CpuPriceHandler::class,
        CpuPartNumberHandler::class,
        GpuImageHandler::class,
        GpuPriceHandler::class,
        GpuPartNumberHandler::class,
        SliCrossfireTypeHandler::class,
        FrameSyncTypeHandler::class,
        ExternalPowerTypeHandler::class,
        GpuCoolingTypeHandler::class,
        GpuPortHandler::class,
        ColorHandler::class,
        StorageImageHandler::class,
        StoragePriceHandler::class,
        StoragePartNumberHandler::class,
        PsuImageHandler::class,
        PsuPriceHandler::class,
        PsuPartNumberHandler::class,
        PsuConnectorHandler::class,
        MemoryImageHandler::class,
        MemoryPriceHandler::class,
        MemoryPartNumberHandler::class,
        MoboHandler::class,
        MoboImageHandler::class,
        MoboPriceHandler::class,
        MotherboardPartNumberHandler::class,
        MoboMemorySpeedTypeHandler::class,
        UsbHandler::class,
        MotherboardsUsbHandler::class,
        MDot2TypeHandler::class,
        OnboardEthernetTypeHandler::class
    ];

    public static function create(string $entityName): ?ResourceHandler
    {
        foreach (self::$handlerNames as $handler)
            if ((new $handler())->isUsed($entityName))
                return new $handler();
        return null;
    }
}