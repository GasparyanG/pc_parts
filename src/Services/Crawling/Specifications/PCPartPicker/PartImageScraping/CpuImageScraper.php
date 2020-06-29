<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping;


use App\Database\Entities\CpuImage;
use App\Database\Entities\Cpu;

class CpuImageScraper extends ImageAbstractScraper
{
    /**
     * {@inheritDoc}
     */
    protected static $name = Cpu::class;

    /**
     * {@inheritDoc}
     */
    protected static $referer = "cpu/";

    public function persist(string $imageFileName, int $id): void
    {
        $cpu = $this->em->getRepository(Cpu::class)->find($id);
        if (!$cpu) return;

        $cpuImage = new CpuImage();
        $cpuImage->setFileName($imageFileName);
        $cpuImage->setCpu($cpu);

        $this->em->persist($cpuImage);
        $this->em->flush();
    }
}