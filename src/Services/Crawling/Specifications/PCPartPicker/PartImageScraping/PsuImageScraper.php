<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping;


use App\Database\Entities\PsuImage;
use App\Database\Entities\PowerSupply;

class PsuImageScraper extends ImageAbstractScraper
{
    /**
     * {@inheritDoc}
     */
    protected static $name = PowerSupply::class;

    /**
     * {@inheritDoc}
     */
    protected static $referer = "power-supply/";

    public function persist(string $imageFileName, int $id): void
    {
        $psu = $this->em->getRepository(PowerSupply::class)->find($id);
        if (!$psu) return;

        $psuImage = new PsuImage();
        $psuImage->setFileName($imageFileName);
        $psuImage->setPsu($psu);

        $this->em->persist($psuImage);
        $this->em->flush();
    }
}