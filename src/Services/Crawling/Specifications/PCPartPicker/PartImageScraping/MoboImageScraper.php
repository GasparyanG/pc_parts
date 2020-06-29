<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping;


use App\Database\Entities\MoboImage;
use App\Database\Entities\Motherboard;

class MoboImageScraper extends ImageAbstractScraper
{
    /**
     * {@inheritDoc}
     */
    protected static $name = Motherboard::class;

    /**
     * {@inheritDoc}
     */
    protected static $referer = "motherboard/";

    public function persist(string $imageFileName, int $id): void
    {
        $motherboard = $this->em->getRepository(Motherboard::class)->find($id);
        if (!$motherboard) return;

        $motherboardImage = new MoboImage();
        $motherboardImage->setFileName($imageFileName);
        $motherboardImage->setMobo($motherboard);

        $this->em->persist($motherboardImage);
        $this->em->flush();
    }
}