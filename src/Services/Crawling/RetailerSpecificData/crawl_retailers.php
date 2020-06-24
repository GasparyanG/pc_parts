<?php

use App\Database\Connection;

require_once __DIR__ . "/../../../../vendor/autoload.php";

$retailers = [
    \App\Services\Crawling\RetailerSpecificData\Retailers\Amazon::class
];

$abstractFactories = [
    \App\Services\Crawling\RetailerSpecificData\AbstractFactories\GpuAbstractFactory::class,
    \App\Services\Crawling\RetailerSpecificData\AbstractFactories\CpuAbstractFactory::class,
    \App\Services\Crawling\RetailerSpecificData\AbstractFactories\PsuAbstractFactory::class
];

function filterPartNumber(string $partNumber): ?string
{
    // TODO: implement properly
    return $partNumber;
}

$em = Connection::getEntityManager();
foreach ($abstractFactories as $abstractFactoryName) {
    $abstractFactory = new $abstractFactoryName();
    $partNumberName = $abstractFactory->getEntity();

    $partNumbers = $em->getRepository($partNumberName)->findAll();

    $nth_is_crawling = count($partNumbers);
    // iterate over part numbers
    foreach ($partNumbers as $partNumberEntity) {
        echo $nth_is_crawling . " left\n";

        $partNumber = filterPartNumber($partNumberEntity->getPartNumber());
        // part number can be invalid, which means, that it doesn't need to be processed
        if (!$partNumber) continue;
        foreach ($retailers as $retailerName) {
            $retailer = new $retailerName();
            $retailer->crawl($partNumber, $partNumberEntity->getEntityId());

            $persistingImplementer = $abstractFactory->getPersistingImplementer($retailer->getCrawledData());
            $persistingImplementer->persist();
        }

        --$nth_is_crawling;
    }
}