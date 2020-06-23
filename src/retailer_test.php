<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Services\Crawling\RetailerSpecificData\Retailers\Amazon;

$am = new Amazon();
$am->crawl("G166SVXSC");

var_dump($am->getCrawledData());