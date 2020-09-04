<?php

require_once __DIR__ . "/../../../../vendor/autoload.php";

use App\Services\Crawling\RetailerSpecificData\Retailers\NewEgg;
use App\Services\Crawling\RetailerSpecificData\Retailers\Walmart;
use App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping\GpuImageScraper;

$ret = new NewEgg();
$ret->crawl("5700XTCHALLENGERD8GO", 65, new GpuImageScraper());
var_dump($ret->getCrawledData());