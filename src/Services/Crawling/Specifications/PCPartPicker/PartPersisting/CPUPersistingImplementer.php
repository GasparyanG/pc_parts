<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartPersisting;


use App\Database\Connection;
use App\Database\Entities\CoreFamily;
use App\Database\Entities\Cpu as CPUEntity;
use App\Database\Entities\CpuPartNumber;
use App\Database\Entities\CpuSeries;
use App\Database\Entities\CpuSocket;
use App\Database\Entities\IntegratedGraphic;
use App\Database\Entities\LOneCache;
use App\Database\Entities\LThreeCache;
use App\Database\Entities\LTwoCache;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\Microarchitecture;
use App\Services\Crawling\Specifications\PCPartPicker\Parts\CPU;
use Doctrine\ORM\EntityManager;

class CPUPersistingImplementer
{
    /**
     * @var CPU
     */
    private $cpuScrapedDataHolder;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(CPU $cooler)
    {
        $this->cpuScrapedDataHolder = $cooler;
        $this->em = Connection::getEntityManager();
    }

    public function insert(): void
    {
        $manufacturer = $this->manufacturer();
        $microarchitecture = $this->microarchitecture();
        $cpuSeries = $this->cpuSeries();
        $integratedGraphic = $this->integratedGraphic();
        $coreFamily = $this->coreFamily();
        $lOneCache = $this->lOneCache();
        $lTwoCache = $this->lTwoCache();
        $lThreeCache = $this->lThreeCache();
        $socket = $this->socket();

        $cpu = new CPUEntity();
        // Many to One Relationships
        $manufacturer->addCpu($cpu);

        if ($microarchitecture)
            $microarchitecture->addCpu($cpu);

        // $cpuSeries addition
        if($cpuSeries)
            $cpuSeries->addCpu($cpu);

        // $integratedGraphic addition
        if($integratedGraphic)
            $integratedGraphic->addCpu($cpu);

        // $coreFamily addition
        if($coreFamily)
            $coreFamily->addCpu($cpu);

        // $lOneCache addition
        if($lOneCache)
            $lOneCache->addCpu($cpu);

        // $lTwoCache addition
        if($lTwoCache)
            $lTwoCache->addCpu($cpu);

        // $lThreeCache addition
        if($lThreeCache)
            $lThreeCache->addCpu($cpu);

        if ($socket)
            $socket->addCpu($cpu);


        $cpu->setName($this->cpuScrapedDataHolder->getName());
        $cpu->setUrl($this->cpuScrapedDataHolder->getUrl());
        $cpu->setBoostClock($this->cpuScrapedDataHolder->getBoostClock());
        $cpu->setCoreClock($this->cpuScrapedDataHolder->getCoreClock());
        $cpu->setEccSupport($this->cpuScrapedDataHolder->getEccSupport());
        $cpu->setIncludesCpuCooler($this->cpuScrapedDataHolder->getIncludesCPUCooler());
        $cpu->setCoreCount($this->cpuScrapedDataHolder->getCoreCount());
        $cpu->setLithography($this->cpuScrapedDataHolder->getLithography());
        $cpu->setModel($this->cpuScrapedDataHolder->getModel());
        $cpu->setTdp($this->cpuScrapedDataHolder->getTdp());
        $cpu->setSmt($this->cpuScrapedDataHolder->getSmt());
        $cpu->setPackaging($this->cpuScrapedDataHolder->getPackaging());
        $cpu->setMaximumSupportedMemory($this->cpuScrapedDataHolder->getMaximumSupportedMemory());

        $this->em->persist($cpu);
        $this->em->flush();

        // One to many relationships
        $this->partNumbers($cpu);

        $this->em->flush($cpu);
    }

    private function manufacturer(): ?Manufacturer
    {
        $manufacturer = $this->em->getRepository(Manufacturer::class)->findOneBy(
            [
                Manufacturer::NAME => $this->cpuScrapedDataHolder->getManufacturer()
            ]
        );

        if (!$manufacturer) {
            $manufacturer = new Manufacturer();
            $manufacturer->setName($this->cpuScrapedDataHolder->getManufacturer());
            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($manufacturer);
            $this->em->flush();
        }

        return $manufacturer;
    }

    private function socket(): ?CpuSocket
    {
        $cpuSocket = $this->em->getRepository(CpuSocket::class)->findOneBy(
            [
                CpuSocket::TYPE => $this->cpuScrapedDataHolder->getSocket()
            ]
        );

        if (!$cpuSocket) {
            $cpuSocket = new CpuSocket();
            $cpuSocket->setType($this->cpuScrapedDataHolder->getSocket());
            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($cpuSocket);
            $this->em->flush();
        }

        return $cpuSocket;
    }

    private function microarchitecture(): ?Microarchitecture
    {
        if (!$this->cpuScrapedDataHolder->getMicroarchitecture())
            return null;

        $microarchitecture = $this->em->getRepository(Microarchitecture::class)->findOneBy(
            [
                Microarchitecture::NAME => $this->cpuScrapedDataHolder->getMicroarchitecture()
            ]
        );

        if (!$microarchitecture) {
            $microarchitecture = new Microarchitecture();
            $microarchitecture->setName($this->cpuScrapedDataHolder->getMicroarchitecture());
            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($microarchitecture);
            $this->em->flush();
        }

        return $microarchitecture;
    }

    private function cpuSeries(): ?CpuSeries
    {
        if (!$this->cpuScrapedDataHolder->getCpuSeries())
            return null;

        $cpuSeries = $this->em->getRepository(CpuSeries::class)->findOneBy(
            [
                CpuSeries::NAME => $this->cpuScrapedDataHolder->getCpuSeries()
            ]
        );

        if (!$cpuSeries) {
            $cpuSeries = new CpuSeries();
            $cpuSeries->setName($this->cpuScrapedDataHolder->getCpuSeries());

            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($cpuSeries);
            $this->em->flush();
        }

        return $cpuSeries;
    }

    private function integratedGraphic(): ?IntegratedGraphic
    {
        if (!$this->cpuScrapedDataHolder->getIntegratedGraphic())
            return null;

        $integratedGraphic = $this->em->getRepository(IntegratedGraphic::class)->findOneBy(
            [
                IntegratedGraphic::NAME => $this->cpuScrapedDataHolder->getIntegratedGraphic()
            ]
        );

        if (!$integratedGraphic) {
            $integratedGraphic = new IntegratedGraphic();
            $integratedGraphic->setName($this->cpuScrapedDataHolder->getIntegratedGraphic());
            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($integratedGraphic);
            $this->em->flush();
        }

        return $integratedGraphic;
    }

    private function coreFamily(): ?CoreFamily
    {
        if (!$this->cpuScrapedDataHolder->getCoreFamily())
            return null;

        $coreFamily = $this->em->getRepository(CoreFamily::class)->findOneBy(
            [
                CoreFamily::NAME => $this->cpuScrapedDataHolder->getCoreFamily()
            ]
        );

        if (!$coreFamily) {
            $coreFamily = new CoreFamily();
            $coreFamily->setName($this->cpuScrapedDataHolder->getCoreFamily());

            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($coreFamily);
            $this->em->flush();
        }

        return $coreFamily;
    }

    private function lOneCache(): ?LOneCache
    {
        $lOneCacheData = $this->cpuScrapedDataHolder->getLOneCache();
        if (!$lOneCacheData || !($lOneCacheData[0] && $lOneCacheData[1]
                && $lOneCacheData[2] && $lOneCacheData[3]))
            return null;

        $persistedLOneCache = $this->em->getRepository(LOneCache::class)->findOneBy(
            [
                LOneCache::INSTRUCTION_AMOUNT => $lOneCacheData[0],
                LOneCache::INSTRUCTION_CAPACITY=> $lOneCacheData[1],
                LOneCache::DATA_AMOUNT => $lOneCacheData[2],
                LOneCache::DATA_CAPACITY=> $lOneCacheData[3]
            ]
        );

        if (!$persistedLOneCache) {
            $lOneCache = new LOneCache();
            $lOneCache->setInstructionAmount($lOneCacheData[0]);
            $lOneCache->setInstructionCapacity($lOneCacheData[1]);
            $lOneCache->setDataAmount($lOneCacheData[2]);
            $lOneCache->setDataCapacity($lOneCacheData[3]);

            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($lOneCache);
            $this->em->flush();

            return $lOneCache;
        }

        return $persistedLOneCache;
    }

    private function lTwoCache(): ?LTwoCache
    {
        $lTwoCacheData = $this->cpuScrapedDataHolder->getLTwoCache();
        if (!$lTwoCacheData || !($lTwoCacheData[0] && $lTwoCacheData[1]))
            return null;

        $persistedLTwoCache = $this->em->getRepository(LTwoCache::class)->findOneBy(
            [
                LTwoCache::AMOUNT => $lTwoCacheData[0],
                LTwoCache::CAPACITY => $lTwoCacheData[1],
            ]
        );

        if (!$persistedLTwoCache) {
            $lTwoCache = new LTwoCache();
            $lTwoCache->setAmount($lTwoCacheData[0]);
            $lTwoCache->setCapacity($lTwoCacheData[1]);

            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($lTwoCache);
            $this->em->flush();

            return $lTwoCache;
        }

        return $persistedLTwoCache;
    }

    private function lThreeCache(): ?LThreeCache
    {
        $lThreeCacheData = $this->cpuScrapedDataHolder->getLThreeCache();
        if (!$lThreeCacheData || !($lThreeCacheData[0] && $lThreeCacheData[1]))
            return null;

        $persistedLThreeCache = $this->em->getRepository(LThreeCache::class)->findOneBy(
            [
                LThreeCache::AMOUNT => $lThreeCacheData[0],
                LThreeCache::CAPACITY => $lThreeCacheData[1],
            ]
        );

        if (!$persistedLThreeCache) {
            $lThreeCache = new LThreeCache();
            $lThreeCache->setAmount($lThreeCacheData[0]);
            $lThreeCache->setCapacity($lThreeCacheData[1]);

            // TODO: try to rely on UoW regarding insertion fo this entity through CoolerEntity (1)
            $this->em->persist($lThreeCache);
            $this->em->flush();

            return $lThreeCache;
        }

        return $persistedLThreeCache;
    }

    private function partNumbers(CPUEntity& $cpu): void
    {
        // At this moment cpu will already have id
        foreach ($this->cpuScrapedDataHolder->getPartNumbers() as $partNumber) {
            $cpuPartNumber = $this->em->getRepository(CpuPartNumber::class)->findOneBy(
                [
                    CpuPartNumber::PART_NUMBER => $partNumber,
                    CpuPartNumber::CPU => $cpu
                ]
            );

            if (!$cpuPartNumber) {
                $cpuPartNumber = new CpuPartNumber();
                $cpuPartNumber->setCpu($cpu);
                $cpuPartNumber->setPartNumber($partNumber);

                $this->em->persist($cpuPartNumber);
                $this->em->flush();
            }
        }
    }
}