<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartPersisting;


use App\Database\Connection;
use App\Database\Entities\BearingType;
use App\Database\Entities\Color;
use App\Database\Entities\Cooler as CoolerEntity;
use App\Database\Entities\CoolerPartNumber;
use App\Database\Entities\CpuSocket;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\WaterCooledType;
use App\Services\Crawling\Specifications\PCPartPicker\Parts\Cooler;
use Doctrine\ORM\EntityManager;

class CoolerPersistingImplementer
{
    /**
     * @var Cooler
     */
    private $coolerScrapedDataHolder;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(Cooler $cooler)
    {
        $this->coolerScrapedDataHolder = $cooler;
        $this->em = Connection::getEntityManager();
    }

    public function insert(): void
    {
        $manufacturer = $this->manufacturer();
        $bearingType = $this->bearingType();
        $waterCooledType = $this->waterCooledType();

        // Cooler Preparation for insertion
        $cooler = new CoolerEntity();
        // foreign keys
        $manufacturer->addCooler($cooler);
        if ($bearingType) {
            $bearingType->addCooler($cooler);
        } else
            $cooler->setBearingType(null);

        if ($waterCooledType) {
            $waterCooledType->addCooler($cooler);
        } else
            $cooler->setWaterCooledType(null);

        // required data
        $cooler->setName($this->coolerScrapedDataHolder->getName());
        $cooler->setUrl($this->coolerScrapedDataHolder->getUrl());

        // secondary data
        $cooler->setFanless($this->coolerScrapedDataHolder->isFanless());
        $cooler->setHeight($this->coolerScrapedDataHolder->getHeight());
        $cooler->setNoiseStart($this->coolerScrapedDataHolder->getNoiseLevelStart());
        $cooler->setNoiseEnd($this->coolerScrapedDataHolder->getNoiseLevelEnd());
        // TODO: change RMP to RPM
        $cooler->setRmpStart($this->coolerScrapedDataHolder->getFanRpmStart());
        $cooler->setRpmEnd($this->coolerScrapedDataHolder->getFanRpmEnd());
        $cooler->setModel($this->coolerScrapedDataHolder->getModel());

        // Insertion
        // TODO: Handle potential errors
        $this->em->persist($cooler);
        $this->em->flush();

        // Collection
        $this->cpuSockets($cooler);
        $this->colors($cooler);
        $this->partNumbers($cooler);

        // persist associations as well
        $this->em->flush($cooler);
    }

    private function manufacturer(): Manufacturer
    {
        $manufacturer = $this->em->getRepository(Manufacturer::class)->findOneBy(
            [
                Manufacturer::NAME => $this->coolerScrapedDataHolder->getManufacturer()
            ]
        );

        if (!$manufacturer) {
            $manufacturer = new Manufacturer();
            $manufacturer->setName($this->coolerScrapedDataHolder->getManufacturer());

            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($manufacturer);
            $this->em->flush();
        }

        return $manufacturer;
    }

    private function bearingType(): ?BearingType
    {
        if (!$this->coolerScrapedDataHolder->getBearingType()) return null;

        $bearingType = $this->em->getRepository(BearingType::class)->findOneBy(
            [
                BearingType::TYPE => $this->coolerScrapedDataHolder->getBearingType()
            ]
        );

        if (!$bearingType) {
            $bearingType = new BearingType();
            $bearingType->setType($this->coolerScrapedDataHolder->getBearingType());

            // TODO: (1)
            $this->em->persist($bearingType);
            $this->em->flush();
        }

        return $bearingType;
    }

    private function waterCooledType(): ?WaterCooledType
    {
        if (!$this->coolerScrapedDataHolder->getWaterCooled()) return null;

        $waterCooledType = $this->em->getRepository(WaterCooledType::class)->findOneBy(
            [
                WaterCooledType::TYPE => $this->coolerScrapedDataHolder->getWaterCooled()
            ]
        );

        if (!$waterCooledType) {
            $waterCooledType = new WaterCooledType();
            $waterCooledType->setType($this->coolerScrapedDataHolder->getWaterCooled());

            // TODO: (1)
            $this->em->persist($waterCooledType);
            $this->em->flush();
        }

        return $waterCooledType;
    }

    private function cpuSockets(CoolerEntity& $cooler): void
    {
        foreach ($this->coolerScrapedDataHolder->getCpuSockets() as $cpuSocket) {
            // getting cpu socket
            $cpuSocketEntity = $this->em->getRepository(CpuSocket::class)->findOneBy(
                [
                    CpuSocket::TYPE => $cpuSocket
                ]
            );

            if (!$cpuSocketEntity) {
                $cpuSocketEntity = new CpuSocket();
                $cpuSocketEntity->setType($cpuSocket);

                // TODO: (1)
                $this->em->persist($cpuSocketEntity);
                $this->em->flush();
            }

            $cooler->addCpuSocket($cpuSocketEntity);
        }
    }

    private function colors(CoolerEntity& $cooler): void
    {
        foreach ($this->coolerScrapedDataHolder->getColors() as $color) {
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

            $cooler->addColor($colorEntity);
        }
    }

    private function partNumbers(CoolerEntity& $cooler): void
    {
        // At this moment cooler will already have id
        foreach ($this->coolerScrapedDataHolder->getPartNumbers() as $partNumber) {
            $coolerPartNumber = $this->em->getRepository(CoolerPartNumber::class)->findOneBy(
                [
                    CoolerPartNumber::PART_NUMBER => $partNumber,
                    CoolerPartNumber::COOLER => $cooler
                ]
            );

            if (!$coolerPartNumber) {
                $coolerPartNumber = new CoolerPartNumber();
                $coolerPartNumber->setCooler($cooler);
                $coolerPartNumber->setPartNumber($partNumber);

                $this->em->persist($coolerPartNumber);
                $this->em->flush();
            }
        }
    }
}