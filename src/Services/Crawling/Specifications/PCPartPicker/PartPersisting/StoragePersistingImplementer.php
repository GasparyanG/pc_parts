<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartPersisting;


use App\Database\Connection;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\Storage as StorageEntity;
use App\Database\Entities\StorageFormFactor;
use App\Database\Entities\StorageInterface;
use App\Database\Entities\StoragePartNumber;
use App\Database\Entities\StorageType;
use App\Services\Crawling\Specifications\PCPartPicker\Parts\Storage;
use Doctrine\ORM\EntityManager;

class StoragePersistingImplementer
{
    /**
     * @var Storage
     */
    private $storageScrapedDataHolder;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(Storage $storage)
    {
        $this->storageScrapedDataHolder = $storage;
        $this->em = Connection::getEntityManager();
    }

    public function insert(): void
    {
        $manufacturer = $this->manufacturer();
        $storageType = $this->storageType();
        $storageFormFactor = $this->storageFormFactor();
        $storageInterface = $this->storageInterface();

        $storage = new StorageEntity();

        $manufacturer->addStorage($storage);

        if ($storageType)
            $storageType->addStorage($storage);

        if ($storageFormFactor)
            $storageFormFactor->addStorage($storage);

        if ($storageInterface)
            $storageInterface->addStorage($storage);

        $storage->setName($this->storageScrapedDataHolder->getName());
        $storage->setUrl($this->storageScrapedDataHolder->getUrl());
        $storage->setCapacity($this->storageScrapedDataHolder->getCapacity());
        $storage->setCache($this->storageScrapedDataHolder->getCache());
        $storage->setNvme($this->storageScrapedDataHolder->getNvme());

        $this->em->persist($storage);
        $this->em->flush();

        $this->storagePartNumbers($storage);

        $this->em->flush($storage);
    }

    private function manufacturer(): Manufacturer
    {
        $manufacturer = $this->em->getRepository(Manufacturer::class)->findOneBy(
            [
                Manufacturer::NAME => $this->storageScrapedDataHolder->getManufacturer()
            ]
        );

        if (!$manufacturer) {
            $manufacturer = new Manufacturer();
            $manufacturer->setName($this->storageScrapedDataHolder->getManufacturer());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($manufacturer);
            $this->em->flush();
        }

        return $manufacturer;
    }

    private function storageType(): ?StorageType
    {
        $storageType = $this->em->getRepository(StorageType::class)->findOneBy(
            [
                StorageType::TYPE => $this->storageScrapedDataHolder->getStorageType()
            ]
        );

        if (!$storageType) {
            $storageType = new StorageType();
            $storageType->setType($this->storageScrapedDataHolder->getStorageType());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($storageType);
            $this->em->flush();
        }

        return $storageType;
    }

    private function storageFormFactor(): ?StorageFormFactor
    {
        $storageFormFactor = $this->em->getRepository(StorageFormFactor::class)->findOneBy(
            [
                StorageFormFactor::TYPE => $this->storageScrapedDataHolder->getStorageFormFactor()
            ]
        );

        if (!$storageFormFactor) {
            $storageFormFactor = new StorageFormFactor();
            $storageFormFactor->setType($this->storageScrapedDataHolder->getStorageFormFactor());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($storageFormFactor);
            $this->em->flush();
        }

        return $storageFormFactor;
    }

    private function storageInterface(): ?StorageInterface
    {
        $storageInterface = $this->em->getRepository(StorageInterface::class)->findOneBy(
            [
                StorageInterface::TYPE => $this->storageScrapedDataHolder->getStorageInterface()
            ]
        );

        if (!$storageInterface) {
            $storageInterface = new StorageInterface();
            $storageInterface->setType($this->storageScrapedDataHolder->getStorageInterface());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($storageInterface);
            $this->em->flush();
        }

        return $storageInterface;
    }

    private function storagePartNumbers(StorageEntity $storage): void
    {
        // At this moment cooler will already have id
        foreach ($this->storageScrapedDataHolder->getPartNumbers() as $partNumber) {
            $storagePartNumber = $this->em->getRepository(StoragePartNumber::class)->findOneBy(
                [
                    StoragePartNumber::PART_NUMBER => $partNumber,
                    StoragePartNumber::STORAGE => $storage
                ]
            );

            if (!$storagePartNumber) {
                $storagePartNumber = new StoragePartNumber();
                $storagePartNumber->setStorage($storage);
                $storagePartNumber->setPartNumber($partNumber);

                $this->em->persist($storagePartNumber);
                $this->em->flush();
            }
        }
    }
}