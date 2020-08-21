<?php

require_once __DIR__ . "/../../../../../../vendor/autoload.php";

use App\Database\Connection;
use App\Database\Entities\
{
    Cooler,
    Cpu,
    Memory,
    Motherboard,
    PcCase,
    PowerSupply,
    Storage,
    VideoCard
};
use App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping\ImageScraperFactory;

$entitiesNames = [
    PcCase::class => "getCaseImages",
    PowerSupply::class => "getPsuImages",
    VideoCard::class => "getGpuImages",
    Cpu::class => "getCpuImages",
    Cooler::class => "getCoolerImages",
    Storage::class => "getStorageImages",
    Memory::class => "getMemoryImages",
    Motherboard::class => "getMoboImages"
];

$em = Connection::getEntityManager();

foreach ($entitiesNames as $entityName => $mName) {
    $entities = $em->getRepository($entityName)->findAll();
    $scraper = ImageScraperFactory::create($entityName);

    foreach ($entities as $entity) {
        if (!count($entity->$mName()))
            $scraper->crawl($entity->getUrl(), $entity->getId());
    }
}
