<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping;


use App\Database\Entities\MemoryImage;
use App\Database\Entities\Memory;

class MemoryImageScraper extends ImageAbstractScraper
{
    /**
     * {@inheritDoc}
     */
    protected static $name = Memory::class;

    /**
     * {@inheritDoc}
     */
    protected static $referer = "memory/";

    public function persist(string $imageFileName, int $id): void
    {
        $memory = $this->em->getRepository(Memory::class)->find($id);
        if (!$memory) return;

        $memoryImage = new MemoryImage();
        $memoryImage->setFileName($imageFileName);
        $memoryImage->setMemory($memory);

        $this->em->persist($memoryImage);
        $this->em->flush();
    }
}