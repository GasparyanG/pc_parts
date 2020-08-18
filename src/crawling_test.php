<?php
require_once __DIR__ . "/../vendor/autoload.php";

use App\Services\Crawling\Specifications\PCPartPicker\PartScraping\
{
    CoolerScraper,
    MemoryScraper,
    CPUScraper,
    StorageScraper,
    PSUScraper,
    MOBOScraping,
    GPUScraper,
    CaseScraper
};

$scraper1 = new PSUScraper();
$scraper1->crawl();

$scraper2 = new MOBOScraping();
$scraper2->crawl();

$scraper3 = new GPUScraper();
$scraper3->crawl();