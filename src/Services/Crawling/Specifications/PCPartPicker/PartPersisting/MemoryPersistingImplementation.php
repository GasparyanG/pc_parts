<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartPersisting;


use App\Database\Connection;
use App\Database\Entities\Color;
use App\Database\Entities\EccRegister;
use App\Database\Entities\FormFactor;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\Memory as MemoryEntity;
use App\Database\Entities\MemoryPartNumber;
use App\Database\Entities\Module;
use App\Database\Entities\Timing;
use App\Services\Crawling\Specifications\PCPartPicker\Parts\Memory;
use Doctrine\ORM\EntityManager;

class MemoryPersistingImplementation
{
    /**
     * @var Memory
     */
    private $memoryScrapedDataHolder;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(Memory $memory)
    {
        $this->memoryScrapedDataHolder = $memory;
        $this->em = Connection::getEntityManager();
    }

    public function insert(): void
    {
        $manufacturer = $this->manufacturer();
        $formFactor = $this->formFactor();
        $module = $this->module();
        $timing = $this->timing();
        $eccRegister = $this->eccRegister();

        $memory = new MemoryEntity();

        $manufacturer->addMemory($memory);

        // relationships
        if ($formFactor)
            $formFactor->addMemory($memory);

        if ($module)
            $module->addMemory($memory);

        if ($timing)
            $timing->addMemory($memory);

        if ($eccRegister)
            $eccRegister->addMemory($memory);

        // scalar types
        $memory->setName($this->memoryScrapedDataHolder->getName());
        $memory->setUrl($this->memoryScrapedDataHolder->getUrl());
        $memory->setSpeed($this->memoryScrapedDataHolder->getSpeed());
        $memory->setType($this->memoryScrapedDataHolder->getType());
        $memory->setVoltage($this->memoryScrapedDataHolder->getVoltage());
        $memory->setHeatSpreader($this->memoryScrapedDataHolder->getHeatSpreader());

        $this->em->persist($memory);
        $this->em->flush();

        $this->memoryPartNumbers($memory);
        $this->colors($memory);

        $this->em->flush($memory);
    }

    private function manufacturer(): Manufacturer
    {
        $manufacturer = $this->em->getRepository(Manufacturer::class)->findOneBy(
            [
                Manufacturer::NAME => $this->memoryScrapedDataHolder->getManufacturer()
            ]
        );

        if (!$manufacturer) {
            $manufacturer = new Manufacturer();
            $manufacturer->setName($this->memoryScrapedDataHolder->getManufacturer());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($manufacturer);
            $this->em->flush();
        }

        return $manufacturer;
    }

    private function formFactor(): ?FormFactor
    {
        $formFactor = $this->em->getRepository(FormFactor::class)->findOneBy(
            [
                FormFactor::TYPE => $this->memoryScrapedDataHolder->getManufacturer()
            ]
        );

        if (!$formFactor) {
            $formFactor = new FormFactor();
            $formFactor->setType($this->memoryScrapedDataHolder->getFormFactor());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($formFactor);
            $this->em->flush();
        }

        return $formFactor;
    }

    private function module(): ?Module
    {
        // TODO: think about null (when either or both is/are null) cases
        $module = $this->em->getRepository(Module::class)->findOneBy(
            [
                Module::CAPACITY => $this->memoryScrapedDataHolder->getCapacity(),
                Module::AMOUNT => $this->memoryScrapedDataHolder->getAmount()
            ]
        );

        if (!$module) {
            $module = new Module();
            $module->setAmount($this->memoryScrapedDataHolder->getAmount());
            $module->setCapacity($this->memoryScrapedDataHolder->getCapacity());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($module);
            $this->em->flush();
        }

        return $module;
    }

    private function timing(): ?Timing
    {
        // TODO: think about null (when either or both is/are null) cases
        $timing = $this->em->getRepository(Timing::class)->findOneBy(
            [
                Timing::CAS_LATENCY => $this->memoryScrapedDataHolder->getCasLatency(),
                Timing::TIMING => $this->memoryScrapedDataHolder->getTiming()
            ]
        );

        if (!$timing) {
            $timing = new Timing;
            $timing->setCasLatency($this->memoryScrapedDataHolder->getCasLatency());
            $timing->setTiming($this->memoryScrapedDataHolder->getTiming());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($timing);
            $this->em->flush();
        }

        return $timing;
    }

    private function eccRegister(): ?EccRegister
    {
        // TODO: think about null (when either or both is/are null) cases
        $eccRegistered = $this->em->getRepository(EccRegister::class)->findOneBy(
            [
                EccRegister::ECC => $this->memoryScrapedDataHolder->getEcc(),
                EccRegister::REGISTERED=> $this->memoryScrapedDataHolder->getRegistered()
            ]
        );

        if (!$eccRegistered) {
            $eccRegistered = new EccRegister();
            $eccRegistered->setEcc($this->memoryScrapedDataHolder->getEcc());
            $eccRegistered->setRegistered($this->memoryScrapedDataHolder->getRegistered());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($eccRegistered);
            $this->em->flush();
        }

        return $eccRegistered;
    }

    private function memoryPartNumbers(MemoryEntity& $memory): void
    {
        // At this moment cooler will already have id
        foreach ($this->memoryScrapedDataHolder->getPartNumbers() as $partNumber) {
            $memoryPartNumber = $this->em->getRepository(MemoryPartNumber::class)->findOneBy(
                [
                    MemoryPartNumber::PART_NUMBER => $partNumber,
                    MemoryPartNumber::MEMORY => $memory
                ]
            );

            if (!$memoryPartNumber) {
                $memoryPartNumber = new MemoryPartNumber();
                $memoryPartNumber->setMemory($memory);
                $memoryPartNumber->setPartNumber($partNumber);

                $this->em->persist($memoryPartNumber);
                $this->em->flush();
            }
        }
    }

    private function colors(MemoryEntity& $memory): void
    {
        foreach ($this->memoryScrapedDataHolder->getColors() as $color) {
            // getting color
            $colorEntity = $this->em->getRepository(Color::class)->findOneBy(
                [
                    Color::NAME => $color
                ]
            );

            if (!$colorEntity) {
                $colorEntity = new Color();
                $colorEntity->setName($color);

                // TODO: (1)
                $this->em->persist($colorEntity);
                $this->em->flush();
            }

            $memory->addColor($colorEntity);
        }
    }
}