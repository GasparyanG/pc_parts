<?php

require_once __DIR__ . "/../../../../../../vendor/autoload.php";

use App\Database\Connection;
use App\Database\Entities\PcCase;
use App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping\CaseImageScraper;

$em = Connection::getEntityManager();
$cases = $em->getRepository(PcCase::class)->findAll();

foreach ($cases as $case) {
    (new CaseImageScraper())->crawl($case->getUrl(), $case->getId());
    break;
}
