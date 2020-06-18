<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartPersisting;


use App\Database\Connection;
use App\Database\Entities\
{Chipset,
    Color,
    ExternalPowerType,
    FrameSyncType,
    GpuCoolingType,
    GpuInterface,
    GpuPartNumber,
    GpuPort,
    Manufacturer,
    MemoryType,
    SliCrossfireType,
    VideoCard
};

use App\Services\Crawling\Specifications\PCPartPicker\Parts\GPU;
use Doctrine\ORM\EntityManager;

class GPUPersistingImplementer
{
    /**
     * @var GPU
     */
    private $gpuScrapedDataHolder;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(GPU $gpu)
    {
        $this->gpuScrapedDataHolder = $gpu;
        $this->em = Connection::getEntityManager();
    }

    public function insert(): void
    {
        // MAny-To-One
        $manufacturer = $this->manufacturer();
        $chipset = $this->chipset();
        $memoryType = $this->memoryType();
        $gpuInterface = $this->gpuInterface();


        $gpu = new VideoCard();
        $manufacturer->addVideoCard($gpu);

        if ($chipset)
            $chipset->addVideoCard($gpu);

        if ($memoryType)
            $memoryType->addVideoCard($gpu);

        if ($gpuInterface)
            $gpuInterface->addVideoCard($gpu);

        // Scalar Types
        $gpu->setName($this->gpuScrapedDataHolder->getName());
        $gpu->setUrl($this->gpuScrapedDataHolder->getUrl());
        $gpu->setMemory($this->gpuScrapedDataHolder->getMemory());
        $gpu->setCoreClock($this->gpuScrapedDataHolder->getCoreClock());
        $gpu->setBoostClock($this->gpuScrapedDataHolder->getBoostClock());
        $gpu->setEffectiveMemoryClock($this->gpuScrapedDataHolder->getEffectiveMemoryClock());
        $gpu->setLength($this->gpuScrapedDataHolder->getLength());
        $gpu->setTdp($this->gpuScrapedDataHolder->getTdp());
        $gpu->setExpansionSlotWidth($this->gpuScrapedDataHolder->getExpansionSlotWidth());

        $this->em->persist($gpu);
        $this->em->flush();

        // Many-To-Many
        $this->partNumbers($gpu);
        $this->colors($gpu);
        $this->externalPowerTypes($gpu);
        $this->gpuCoolingType($gpu);
        $this->sliCrossfireTypes($gpu);
        $this->sliFrameSyncTypes($gpu);
        $this->gpuPorts($gpu);

        $this->em->flush();
    }

    private function manufacturer(): ?Manufacturer
    {
        $manufacturer = $this->em->getRepository(Manufacturer::class)->findOneBy(
            [
                Manufacturer::NAME => $this->gpuScrapedDataHolder->getManufacturer()
            ]
        );

        if (!$manufacturer) {
            $manufacturer = new Manufacturer();
            $manufacturer->setName($this->gpuScrapedDataHolder->getManufacturer());
            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($manufacturer);
            $this->em->flush();
        }

        return $manufacturer;
    }

    private function chipset(): ?Chipset
    {
        if (!$this->gpuScrapedDataHolder->getChipset()) return null;

        $chipset = $this->em->getRepository(Chipset::class)->findOneBy(
            [
                Chipset::TYPE => $this->gpuScrapedDataHolder->getChipset()
            ]
        );

        if (!$chipset) {
            $chipset = new Chipset();
            $chipset->setType($this->gpuScrapedDataHolder->getChipset());
            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($chipset);
            $this->em->flush();
        }

        return $chipset;
    }

    private function memoryType(): ?MemoryType
    {
        if (!$this->gpuScrapedDataHolder->getMemoryType()) return null;

        $memoryType = $this->em->getRepository(MemoryType::class)->findOneBy(
            [
                MemoryType::TYPE => $this->gpuScrapedDataHolder->getMemoryType()
            ]
        );

        if (!$memoryType) {
            $memoryType = new MemoryType();
            $memoryType->setType($this->gpuScrapedDataHolder->getMemoryType());
            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($memoryType);
            $this->em->flush();
        }

        return $memoryType;
    }

    private function gpuInterface(): ?GpuInterface
    {
        if (!$this->gpuScrapedDataHolder->getGpuInterface()) return null;

        $arr = $this->gpuScrapedDataHolder->getGpuInterface();
        $type = array_keys($arr)[0] ?? null;
        $amount = $arr[$type] ?? null;

        if ($type && $amount) return null;

        $gpuInterface = $this->em->getRepository(GpuInterface::class)->findOneBy(
            [
                GpuInterface::TYPE => $type,
                GpuInterface::SLOT_COUNT => $amount,
            ]
        );

        if (!$gpuInterface) {
            $gpuInterface = new GpuInterface();
            $gpuInterface->setType($type);
            $gpuInterface->setSlotCount($amount);
            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($gpuInterface);
            $this->em->flush();
        }

        return $gpuInterface;
    }

    private function sliCrossfireTypes(VideoCard& $gpu): void
    {
        if (!$this->gpuScrapedDataHolder->getSliCrossfireType()) return;

        foreach ($this->gpuScrapedDataHolder->getSliCrossfireType() as $sliCrossfireType) {
            $sliCrossfire = $this->em->getRepository(SliCrossfireType::class)->findOneBy(
                [
                    SliCrossfireType::TYPE => $sliCrossfireType
                ]
            );

            if (!$sliCrossfire) {
                $sliCrossfire = new SliCrossfireType();
                $sliCrossfire->setType($sliCrossfireType);

                $this->em->persist($sliCrossfire);
                $this->em->flush();
            }

            $gpu->addSliCrossfireType($sliCrossfire);
        }
    }

    private function sliFrameSyncTypes(VideoCard& $gpu): void
    {
        if (!$this->gpuScrapedDataHolder->getFrameSyncType()) return;

        foreach ($this->gpuScrapedDataHolder->getFrameSyncType() as $frameSycn) {
            $frameSyncType = $this->em->getRepository(FrameSyncType::class)->findOneBy(
                [
                    FrameSyncType::TYPE => $frameSycn
                ]
            );

            if (!$frameSyncType) {
                $frameSyncType = new FrameSyncType();
                $frameSyncType->setType($frameSycn);

                $this->em->persist($frameSyncType);
                $this->em->flush();
            }

            $gpu->addFrameSyncType($frameSyncType);
        }
    }

    private function partNumbers(VideoCard& $gpu): void
    {
        if (!$this->gpuScrapedDataHolder->getPartNumbers()) return;

        // At this moment cooler will already have id
        foreach ($this->gpuScrapedDataHolder->getPartNumbers() as $partNumber) {
            $gpuPartNumber = $this->em->getRepository(GpuPartNumber::class)->findOneBy(
                [
                    GpuPartNumber::PART_NUMBER => $partNumber,
                    GpuPartNumber::VIDEO_CARD => $gpu
                ]
            );

            if (!$gpuPartNumber) {
                $gpuPartNumber = new GpuPartNumber();
                $gpuPartNumber->setVideoCard($gpu);
                $gpuPartNumber->setPartNumber($partNumber);

                $this->em->persist($gpuPartNumber);
                $this->em->flush();
            }
        }
    }

    private function colors(VideoCard& $gpu): void
    {
        if (!$this->gpuScrapedDataHolder->getColors()) return;

        foreach ($this->gpuScrapedDataHolder->getColors() as $color) {
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

            $gpu->addColor($colorEntity);
        }
    }

    private function externalPowerTypes(VideoCard& $gpu): void
    {
        if (!$this->gpuScrapedDataHolder->getExternalPowerTypes()) return;

        foreach($this->gpuScrapedDataHolder->getExternalPowerTypes() as $powerType) {
            if ($powerType) {
                $amount = $powerType[GPU::AMOUNT];
                $type = $powerType[GPU::TYPE];
                $pinAmount = $powerType[GPU::PIN_AMOUNT];

                $exPow = $this->em->getRepository(ExternalPowerType::class)->findOneBy(
                    [
                        ExternalPowerType::AMOUNT => $amount,
                        ExternalPowerType::TYPE => $type,
                        ExternalPowerType::PIN_AMOUNT => $pinAmount
                    ]
                );

                if (!$exPow) {
                    $exPow = new ExternalPowerType();
                    $exPow->setType($type);
                    $exPow->setAmount($amount);
                    $exPow->setPinAmount($pinAmount);

                    $this->em->persist($exPow);
                    $this->em->flush();
                }

                $gpu->addExternalPowerType($exPow);
            }
        }
    }

    private function gpuCoolingType(VideoCard& $gpu): void
    {
        if (!$this->gpuScrapedDataHolder->getGpuCoolingTypes()) return;

        foreach($this->gpuScrapedDataHolder->getGpuCoolingTypes() as $coolingType) {
            if ($coolingType) {
                $type = $coolingType[GPU::TYPE];
                $measure = $coolingType[GPU::MEASURE];

                $gpuCoolingType = $this->em->getRepository(GpuCoolingType::class)->findOneBy(
                    [
                        GpuCoolingType::TYPE => $type,
                        GpuCoolingType::MEASURE => $measure
                    ]
                );

                if (!$gpuCoolingType) {
                    $gpuCoolingType = new GpuCoolingType();
                    $gpuCoolingType->setType($type);
                    $gpuCoolingType->setMeasure($measure);

                    $this->em->persist($gpuCoolingType);
                    $this->em->flush();
                }

                $gpu->addGpuCoolingType($gpuCoolingType);
            }
        }
    }

    private function gpuPorts(VideoCard& $gpu): void
    {
        if (!$this->gpuScrapedDataHolder->getGpuPorts()) return;

        foreach($this->gpuScrapedDataHolder->getGpuPorts() as $port => $amount) {
            $gpuPort = $this->em->getRepository(GpuPort::class)->findOneBy(
                [
                    GpuPort::TYPE => $port,
                    GpuPort::AMOUNT => $amount
                ]
            );

            if (!$gpuPort) {
                $gpuPort = new GpuPort();
                $gpuPort->setType($port);
                $gpuPort->setAmount($amount);

                $this->em->persist($gpuPort);
                $this->em->flush();
            }

            $gpu->addGpuPort($gpuPort);
        }
    }
}
