<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping;


use App\Database\Entities\StorageImage;
use App\Database\Entities\Storage;

class StorageImageScraper extends ImageAbstractScraper
{
    /**
     * {@inheritDoc}
     */
    protected static $name = Storage::class;

    /**
     * {@inheritDoc}
     */
    protected static $referer = "internal-hard-drive/";

    public function persist(string $imageFileName, int $id): void
    {
        $storage = $this->em->getRepository(Storage::class)->find($id);
        if (!$storage) return;

        $storageImage = new StorageImage();
        $storageImage->setFileName($imageFileName);
        $storageImage->setStorage($storage);

        $this->em->persist($storageImage);
        $this->em->flush();
    }
}