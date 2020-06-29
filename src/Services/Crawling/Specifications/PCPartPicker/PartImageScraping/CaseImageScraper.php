<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping;


use App\Services\Crawling\Specifications\PCPartPicker\Parts\PcCase;

class CaseImageScraper extends ImageAbstractScraper
{
    /**
     * {@inheritDoc}
     */
    protected static $name = PcCase::class;

    /**
     * {@inheritDoc}
     */
    protected static $referer = "case/";

    public function persist(string $imageFileName, int $id): void
    {

    }
}