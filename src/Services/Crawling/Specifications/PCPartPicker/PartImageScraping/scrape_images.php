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

// TODO: uncomment PcCase
$entitiesNames = [
    PcCase::class,
    PowerSupply::class,
    VideoCard::class,
    // TODO: crawl below part images!
    Cpu::class,
    Cooler::class,
    Storage::class,
    Memory::class,
    Motherboard::class
];

$em = Connection::getEntityManager();

foreach ($entitiesNames as $entityName) {
    $entities = $em->getRepository($entityName)->findAll();
    $scraper = ImageScraperFactory::create($entityName);

    foreach ($entities as $entity)
        $scraper->crawl($entity->getUrl(), $entity->getId());
}
