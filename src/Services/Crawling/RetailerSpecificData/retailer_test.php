<?php

require_once __DIR__ . "/../../../../vendor/autoload.php";

use App\Services\Crawling\RetailerSpecificData\Retailers\Walmart;

$ret = new Walmart();
$ret->crawl("G166SVXSC", 7);
var_dump($ret->getCrawledData());