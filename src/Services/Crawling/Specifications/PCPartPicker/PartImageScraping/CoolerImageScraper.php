<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping;


use App\Database\Entities\CoolerImage;
use App\Database\Entities\Cooler;

class CoolerImageScraper extends ImageAbstractScraper
{
    /**
     * {@inheritDoc}
     */
    protected static $name = Cooler::class;

    /**
     * {@inheritDoc}
     */
    protected static $referer = "cpu-cooler/";

    public function persist(string $imageFileName, int $id): void
    {
        $cooler = $this->em->getRepository(Cooler::class)->find($id);
        if (!$cooler) return;

        $coolerImage = new CoolerImage();
        $coolerImage->setFileName($imageFileName);
        $coolerImage->setCooler($cooler);

        $this->em->persist($coolerImage);
        $this->em->flush();
    }
}