<?php
require_once __DIR__ . "/../vendor/autoload.php";

use App\Services\Crawling\Specifications\PCPartPicker\PartScraping\CoolerScraper;
use App\Services\Crawling\Specifications\PCPartPicker\PartScraping\MemoryScraper;

$memoryScraper = new MemoryScraper();
$memoryScraper->crawl();