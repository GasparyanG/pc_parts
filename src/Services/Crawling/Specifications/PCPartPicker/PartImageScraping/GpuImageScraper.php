<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping;


use App\Database\Entities\GpuImage;
use App\Database\Entities\VideoCard;

class GpuImageScraper extends ImageAbstractScraper
{
    /**
     * {@inheritDoc}
     */
    protected static $name = VideoCard::class;

    /**
     * {@inheritDoc}
     */
    protected static $referer = "video-card/";

    public function persist(string $imageFileName, int $id): void
    {
        $gpu = $this->em->getRepository(VideoCard::class)->find($id);
        if (!$gpu) return;

        $gpuImage = new GpuImage();
        $gpuImage->setFileName($imageFileName);
        $gpuImage->setGpu($gpu);

        $this->em->persist($gpuImage);
        $this->em->flush();
    }
}