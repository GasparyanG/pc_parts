<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartPersisting;


use App\Database\Connection;
use App\Database\Entities\
{
    Chipset,
    Color,
    CpuSocket,
    Manufacturer,
    MDot2Type,
    MemoryType,
    MoboFormFactor,
    MoboMemorySpeedType,
    Motherboard,
    MotherboardPartNumber,
    MotherboardSataType,
    MotherboardsUsb,
    OnboardEthernetType,
    Pcie,
    SliCrossfireType,
    Usb,
    WirelessNetworkingType
};

use App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum\MOBOExtractionEnum;
use App\Services\Crawling\Specifications\PCPartPicker\Parts\MOBO;
use Doctrine\ORM\EntityManager;

class MOBOPersistingImplementation
{
    /**
     * @var MOBO
     */
    private $moboScrapedDataHolder;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(MOBO $mobo)
    {
        $this->moboScrapedDataHolder = $mobo;
        $this->em = Connection::getEntityManager();
    }

    public function insert(): void
    {
        // Many-To-One
        $manufacturer = $this->manufacturer();
        $cpuSocket = $this->cpuSocket();
        $moboFormFactor = $this->moboFormFactor();
        $chipset = $this->chipset();
        $memoryType = $this->memoryType();
        $wirelessNetworkingType = $this->wirelessNetworkingType();

        $mobo = new Motherboard();
        $manufacturer->addMotherboard($mobo);

        if ($cpuSocket)
            $cpuSocket->addMotherboard($mobo);

        if ($moboFormFactor)
            $moboFormFactor->addMotherboard($mobo);

        if ($chipset)
            $chipset->addMotherboard($mobo);

        if ($memoryType)
            $memoryType->addMotherboard($mobo);

        if ($wirelessNetworkingType)
            $wirelessNetworkingType->addMotherboard($mobo);

        // Scalar Fields
        $mobo->setName($this->moboScrapedDataHolder->getName());
        $mobo->setUrl($this->moboScrapedDataHolder->getUrl());
        $mobo->setMaxMemory($this->moboScrapedDataHolder->getMaxMemory());
        $mobo->setMemorySlots($this->moboScrapedDataHolder->getMemorySlots());
        $mobo->setOnboardVideo($this->moboScrapedDataHolder->getOnboardVideo());
        $mobo->setSupportsEcc($this->moboScrapedDataHolder->getSupportsEcc());
        $mobo->setRaidSupport($this->moboScrapedDataHolder->getRaidSupport());
        $mobo->setPciSlots($this->moboScrapedDataHolder->getPciSlots());
        $mobo->setMsataSlots($this->moboScrapedDataHolder->getMSataSlots());
        $mobo->setStataExpress($this->moboScrapedDataHolder->getSataExpress());

        $this->em->persist($mobo);
        $this->em->flush();

        // One-To-Many
        $this->moboMemorySpeedTypes($mobo);     // X
        $this->onboardEthernetTypes($mobo);     // X
        $this->partNumbers($mobo);              // X
        $this->motherboardSataTypes($mobo);     // X
        $this->usbs($mobo);                     // X
        $this->pcies($mobo);                    // X

        // Many-To-Many
        $this->mDot2Types($mobo);
        $this->sliCrossfireTypes($mobo);
        $this->colors($mobo);

        $this->em->flush();
    }

    private function manufacturer(): Manufacturer
    {
        $manufacturer = $this->em->getRepository(Manufacturer::class)->findOneBy(
            [
                Manufacturer::NAME => $this->moboScrapedDataHolder->getManufacturer()
            ]
        );

        if (!$manufacturer) {
            $manufacturer = new Manufacturer();
            $manufacturer->setName($this->moboScrapedDataHolder->getManufacturer());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($manufacturer);
            $this->em->flush();
        }

        return $manufacturer;
    }

    private function cpuSocket(): ?CpuSocket
    {
        if (!$this->moboScrapedDataHolder->getCpuSocket()) return null;

        $cpuSocket = $this->em->getRepository(CpuSocket::class)->findOneBy(
            [
                CpuSocket::TYPE => $this->moboScrapedDataHolder->getCpuSocket()
            ]
        );

        if (!$cpuSocket) {
            $cpuSocket = new CpuSocket();
            $cpuSocket->setType($this->moboScrapedDataHolder->getCpuSocket());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($cpuSocket);
            $this->em->flush();
        }

        return $cpuSocket;
    }

    private function moboFormFactor(): ?MoboFormFactor
    {
        if (!$this->moboScrapedDataHolder->getFormFactor()) return null;

        $formFactor = $this->em->getRepository(MoboFormFactor::class)->findOneBy(
            [
                MoboFormFactor::TYPE => $this->moboScrapedDataHolder->getFormFactor()
            ]
        );

        if (!$formFactor) {
            $formFactor = new MoboFormFactor();
            $formFactor->setType($this->moboScrapedDataHolder->getFormFactor());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($formFactor);
            $this->em->flush();
        }

        return $formFactor;
    }

    private function chipset(): ?Chipset
    {
        if (!$this->moboScrapedDataHolder->getChipset()) return null;

        $chipset = $this->em->getRepository(Chipset::class)->findOneBy(
            [
                Chipset::TYPE => $this->moboScrapedDataHolder->getChipset()
            ]
        );

        if (!$chipset) {
            $chipset = new Chipset();
            $chipset->setType($this->moboScrapedDataHolder->getChipset());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($chipset);
            $this->em->flush();
        }

        return $chipset;
    }

    private function memoryType(): ?MemoryType
    {
        if (!$this->moboScrapedDataHolder->getMemoryType()) return null;

        $memoryType = $this->em->getRepository(MemoryType::class)->findOneBy(
            [
                MemoryType::TYPE => $this->moboScrapedDataHolder->getMemoryType()
            ]
        );

        if (!$memoryType) {
            $memoryType = new MemoryType();
            $memoryType->setType($this->moboScrapedDataHolder->getMemoryType());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($memoryType);
            $this->em->flush();
        }

        return $memoryType;
    }

    private function wirelessNetworkingType(): ?WirelessNetworkingType
    {
        if (!$this->moboScrapedDataHolder->getWirelessNetworkingType()) return null;

        $wirelessNetworkingType = $this->em->getRepository(WirelessNetworkingType::class)->findOneBy(
            [
                WirelessNetworkingType::TYPE => $this->moboScrapedDataHolder->getWirelessNetworkingType()
            ]
        );

        if (!$wirelessNetworkingType) {
            $wirelessNetworkingType = new WirelessNetworkingType();
            $wirelessNetworkingType->setType($this->moboScrapedDataHolder->getWirelessNetworkingType());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($wirelessNetworkingType);
            $this->em->flush();
        }

        return $wirelessNetworkingType;
    }

    private function moboMemorySpeedTypes(Motherboard& $mobo): void
    {
        if (!$this->moboScrapedDataHolder->getMoboMemorySpeedTypes()) return;

        foreach ($this->moboScrapedDataHolder->getMoboMemorySpeedTypes() as $memoryName => $memorySpeed) {
            $memoryType = $this->em->getRepository(MemoryType::class)->findOneBy(
                [
                    MemoryType::TYPE => $memoryName
                ]
            );

            if (!$memoryType) {
                $memoryType = new MemoryType();
                $memoryType->setType($memoryName);

                $this->em->persist($memoryType);
                $this->em->flush();
            }

            $moboMemorySpeedType = $this->em->getRepository(MoboMemorySpeedType::class)->findOneBy(
                [
                    MoboMemorySpeedType::SPEED => $memorySpeed,
                    MoboMemorySpeedType::MEMORY_TYPE => $memoryType,
                    MoboMemorySpeedType::MOTHERBOARD => $mobo,
                ]
            );

            if (!$moboMemorySpeedType) {
                $moboMemorySpeedType = new MoboMemorySpeedType();
                $moboMemorySpeedType->setSpeed($memorySpeed);
                $moboMemorySpeedType->setMotherboard($mobo);
                $moboMemorySpeedType->setMemoryType($memoryType);

                $this->em->persist($moboMemorySpeedType);
                $this->em->flush();
            }

            $mobo->addMoboMemorySpeedType($moboMemorySpeedType);
        }
    }

    private function sliCrossfireTypes(Motherboard& $mobo): void
    {
        if (!$this->moboScrapedDataHolder->getSliCrossfireTypes()) return;

        foreach ($this->moboScrapedDataHolder->getSliCrossfireTypes() as $sliCrossfireType) {
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

            $mobo->addSliCrossfireType($sliCrossfire);
        }
    }

    private function mDot2Types(Motherboard& $mobo)
    {
        if (!$this->moboScrapedDataHolder->getMDot2Types()) return;

        foreach ($this->moboScrapedDataHolder->getMDot2Types() as $m2Key => $m2Sizes) {
            foreach ($m2Sizes as $size) {
                $mDot2Slots = $this->em->getRepository(MDot2Type::class)->findOneBy(
                    [
                        MDot2Type::KEY_TYPE => $m2Key,
                        MDot2Type::SIZES => $size
                    ]
                );

                if (!$mDot2Slots) {
                    $mDot2Slots = new MDot2Type();
                    $mDot2Slots->setKeyType($m2Key);
                    $mDot2Slots->setSizes($size);

                    $this->em->persist($mDot2Slots);
                    $this->em->flush();
                }

                $mobo->addMDot2Type($mDot2Slots);
            }
        }
    }

    private function onboardEthernetTypes(Motherboard& $mobo): void
    {
        if (!$this->moboScrapedDataHolder->getOnboardEthernetTypes()) return;

        foreach ($this->moboScrapedDataHolder->getOnboardEthernetTypes() as $arr) {
            $onEthernet = $this->em->getRepository(OnboardEthernetType::class)->findOneBy(
                [
                    OnboardEthernetType::AMOUNT => $arr[0],
                    OnboardEthernetType::SPEED => $arr[1],
                    OnboardEthernetType::MOTHERBOARD => $mobo
                ]
            );

            if (!$onEthernet) {
                $onEthernet = new OnboardEthernetType();
                $onEthernet->setAmount($arr[0]);
                $onEthernet->setSpeed($arr[1]);
                $onEthernet->setMotherboard($mobo);

                $this->em->persist($onEthernet);
                $this->em->flush();
            }

            $mobo->addOnboardEthernetType($onEthernet);
        }
    }

    private function colors(Motherboard& $mobo): void
    {
        if (!$this->moboScrapedDataHolder->getColors()) return;

        foreach ($this->moboScrapedDataHolder->getColors() as $color) {
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

            $mobo->addColor($colorEntity);
        }
    }

    private function partNumbers(Motherboard& $mobo): void
    {
        if (!$this->moboScrapedDataHolder->getPartNumbers()) return;

        // At this moment cooler will already have id
        foreach ($this->moboScrapedDataHolder->getPartNumbers() as $partNumber) {
            $moboPartNumbers = $this->em->getRepository(MotherboardPartNumber::class)->findOneBy(
                [
                    MotherboardPartNumber::PART_NUMBER => $partNumber,
                    MotherboardPartNumber::MOTHERBOARD => $mobo
                ]
            );

            if (!$moboPartNumbers) {
                $moboPartNumbers = new MotherboardPartNumber();
                $moboPartNumbers->setMotherboard($mobo);
                $moboPartNumbers->setPartNumber($partNumber);

                $this->em->persist($moboPartNumbers);
                $this->em->flush();
            }
        }
    }

    private function motherboardSataTypes(Motherboard& $mobo): void
    {
        if (!$this->moboScrapedDataHolder->getMotherboardSataTypes()) return;

        foreach ($this->moboScrapedDataHolder->getMotherboardSataTypes() as $key => $amount) {
            $motherboardSataType = $this->em->getRepository(MotherboardSataType::class)->findOneBy(
                [
                    MotherboardSataType::SPEED => MOBOExtractionEnum::sata_speed($key),
                    MotherboardSataType::AMOUNT => $amount,
                    MotherboardSataType::MOTHERBOARD => $mobo
                ]
            );

            if (!$motherboardSataType) {
                $motherboardSataType = new MotherboardSataType();
                $motherboardSataType->setSpeed(MOBOExtractionEnum::sata_speed($key));
                $motherboardSataType->setAmount($amount);
                $motherboardSataType->setMotherboard($mobo);

                $this->em->persist($motherboardSataType);
                $this->em->flush();
            }

            $mobo->addMotherboardSataType($motherboardSataType);
        }
    }

    private function usbs(Motherboard& $mobo): void
    {
        if (!$this->moboScrapedDataHolder->getUsbs()) return;

        foreach ($this->moboScrapedDataHolder->getUsbs() as $name => $amount) {
            $gen = MOBOExtractionEnum::usb_details($name)[1] ?? null;
            $ver = MOBOExtractionEnum::usb_details($name)[0] ?? null;

            $usb = $this->em->getRepository(Usb::class)->findOneBy(
                [
                    Usb::VERSION => $ver,
                    USB::GENERATION => $gen
                ]
            );

            if (!$usb) {
                $usb = new Usb();
                $usb->setGeneration($gen);
                $usb->setVersion($ver);

                $this->em->persist($usb);
                $this->em->flush();
            }

            $motherboardsUsb = $this->em->getRepository(MotherboardsUsb::class)->findOneBy(
                [
                    MotherboardsUsb::MOTHERBOARD => $mobo,
                    MotherboardsUsb::USB => $usb
                ]
            );

            if (!$motherboardsUsb) {
                $motherboardsUsb = new MotherboardsUsb();
                $motherboardsUsb->setMotherboard($mobo);
                $motherboardsUsb->setUsb($usb);
                $motherboardsUsb->setAmount($amount);

                $this->em->persist($motherboardsUsb);
                $this->em->flush();
            }

            $mobo->addUsb($motherboardsUsb);
        }
    }

    private function pcies(Motherboard& $mobo): void
    {
        if (!$this->moboScrapedDataHolder->getPcies()) return;

        foreach ($this->moboScrapedDataHolder->getPcies() as $key => $amount) {
            $pcie = $this->em->getRepository(Pcie::class)->findOneBy(
                [
                    Pcie::SLOTS_COUNT => MOBOExtractionEnum::pcie_slots($key),
                    Pcie::AMOUNT => $amount,
                    Pcie::MOTHERBOARD => $mobo
                ]
            );

            if (!$pcie) {
                $pcie = new Pcie();
                $pcie->setAmount($amount);
                $pcie->setMotherboard($mobo);
                $pcie->setSlotsCount(MOBOExtractionEnum::pcie_slots($key));

                $this->em->persist($pcie);
                $this->em->flush();
            }

            $mobo->addPcie($pcie);
        }
    }
}
