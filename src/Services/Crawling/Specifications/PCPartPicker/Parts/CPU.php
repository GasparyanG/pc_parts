<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\Parts;


use App\Database\Entities\CoreFamily;
use App\Database\Entities\CpuSeries;
use App\Database\Entities\IntegratedGraphic;
use App\Database\Entities\LOneCache;
use App\Database\Entities\LThreeCache;
use App\Database\Entities\LTwoCache;
use App\Database\Entities\Microarchitecture;
use App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum\CPUExtractionEnum;

class CPU
{
    const NAME = "name";
    const URL = "url";

    /**
     * @var array
     */
    private $scrapedData = [];

    /**
     * @var null|string
     */
    private $name;

    /**
     * @var null|string
     */
    private $url;

    /**
     * @var null|string
     */
    private $manufacturer = null;

    /**
     * @var null|string
     */
    private $model = null;

    /**
     * @var null|array
     */
    private $partNumbers = [];

    /**
     * @var null|int
     */
    private $coreCount = null;

    /**
     * @var null|float
     */
    private $coreClock = null;

    /**
     * @var null|float
     */
    private $boostClock = null;

    /**
     * @var null|float
     */
    private $tdp = null;

    /**
     * @var null|bool
     */
    private $includesCPUCooler = null;

    /**
     * @var null|bool
     */
    private $eccSupport = null;

    /**
     * @var null|bool
     */
    private $smt = null;

    /**
     * @var null|string
     */
    private $packaging = null;

    /**
     * @var null|float
     */
    private $maximumSupportedMemory = null;

    /**
     * @var null|float
     */
    private $lithography = null;

    /**
     * @var CpuSeries
     */
    private $cpuSeries;

    /**
     * @var Microarchitecture
     */
    private $microarchitecture;

    /**
     * @var IntegratedGraphic
     */
    private $integratedGraphic;

    /**
     * @var CoreFamily
     */
    private $coreFamily;

    /**
     * @var LOneCache|null
     */
    private $lOneCache;

    /**
     * @var LTwoCache|null
     */
    private $lTwoCache;

    /**
     * @var LThreeCache|null
     */
    private $lThreeCache;

    public function __construct(array $scrapedData)
    {
        $this->scrapedData = $scrapedData;
        $this->initialize();
    }

    private function initialize(): void
    {
        $this->name();
        $this->url();
        $this->manufacturer();
        $this->model();
        $this->partNumbers();
        $this->coreCount();
        $this->coreClock();
        $this->boostClock();
        $this->tdp();
        $this->includesCPUCooler();
        $this->eccSupport();
        $this->smt();
        $this->packaging();
        $this->maximumSupportedMemory();
        $this->lithography();
        $this->cpuSeries();
        $this->microarchitecture();
        $this->integratedGraphic();
        $this->coreFamily();
        $this->lOneCache();
        $this->lTwoCache();
        $this->lThreeCache();
    }

    public function toArray()
    {
        $dataToReturn = [];
        $dataToReturn[self::NAME] = $this->name;
        $dataToReturn[self::URL] = $this->url;
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::MANUFACTURER)] = $this->manufacturer;
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::MODEL)] = $this->model;
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::PART_NUMBER)] = $this->partNumbers;
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::CORE_COUNT)] = $this->coreCount;
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::CORE_CLOCK)] = $this->coreClock;
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::TDP)] = $this->tdp;
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::INCLUDES_CPU_COOLER)] = $this->includesCPUCooler;
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::ECC_SUPPORT)] = $this->eccSupport;
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::SIMULTANEOUS_MULTITHREADING)] = $this->smt;
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::PACKAGING)] = $this->packaging;
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::MAXIMUM_SUPPORTED_MEMORY)] = $this->maximumSupportedMemory;
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::SERIES)] = $this->cpuSeries->toArray();
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::MICROARCHITECTURE)] = $this->microarchitecture->toArray();
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::INTEGRATED_GRAPHICS)] = $this->integratedGraphic->toArray();
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::CORE_FAMILY)] = $this->coreFamily->toArray();
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::L1_CACHE)] = $this->lOneCache->toArray();
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::L2_CACHE)] = $this->lTwoCache->toArray();
        $dataToReturn[CPUExtractionEnum::get_key(CPUExtractionEnum::L3_CACHE)] = $this->lThreeCache->toArray();

        return $dataToReturn;
    }

    private function name(): void
    {
        if (isset($this->scrapedData[self::NAME]))
            $this->name = $this->scrapedData[self::NAME];
        else
            throw new \InvalidArgumentException("Required filed: name is absent!");
    }

    private function url(): void
    {
        if (isset($this->scrapedData[self::URL]))
            $this->url = $this->scrapedData[self::URL];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(self::URL));
    }

    private function manufacturer(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::MANUFACTURER)]))
            $this->manufacturer = $this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::MANUFACTURER)];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(CPUExtractionEnum::MANUFACTURER));
    }

    private function model(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::MODEL)]))
            $this->model = $this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::MODEL)];
    }

    private function partNumbers(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::PART_NUMBER)]))
            $this->partNumbers = is_array($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::PART_NUMBER)])
                ? $this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::PART_NUMBER)]
                : [$this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::PART_NUMBER)]];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(CPUExtractionEnum::PART_NUMBER));
    }

    private function coreCount(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::CORE_COUNT)]))
            $this->coreCount = $this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::CORE_COUNT)];
    }

    private function coreClock(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::CORE_CLOCK)]))
            $this->coreClock =
                $this->prepareSpeedOfWork($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::CORE_CLOCK)]);
    }

    private function boostClock(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::BOOST_CLOCK)]))
            $this->boostClock =
                $this->prepareSpeedOfWork($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::BOOST_CLOCK)]);
    }

    private function prepareSpeedOfWork(string $string): ?string
    {
        $pattern = "~([\d.]+)\s*GHz~i";
        $matches = [];
        preg_match($pattern, $string, $matches);

        if (count($matches) > 0) {
            return $matches[1];
        }

        return null;
    }

    private function tdp(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::TDP)]))
            $this->tdp
                = $this->prepareTDP($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::TDP)]);
    }

    private function prepareTDP(string $tdpString): ?string
    {
        $pattern = "~([\d.]+)\s*W~i";
        $matches = [];
        preg_match($pattern, $tdpString, $matches);

        if (count($matches) > 0) {
            return $matches[1];
        }

        return null;
    }

    private function includesCPUCooler(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::INCLUDES_CPU_COOLER)]))
            $this->includesCPUCooler =
                $this->supports($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::INCLUDES_CPU_COOLER)]);
    }

    private function eccSupport(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::ECC_SUPPORT)]))
            $this->eccSupport =
                $this->supports($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::ECC_SUPPORT)]);
    }

    private function smt(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::INCLUDES_CPU_COOLER)]))
            $this->smt =
                $this->supports($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::SIMULTANEOUS_MULTITHREADING)]);
    }

    private function supports(string $string): bool
    {
        $pattern = "~No.*~i";
        $matches = [];
        preg_match($pattern, $string, $matches);

        if (count($matches) > 0)
            return false;

        return true;
    }

    private function packaging(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::PACKAGING)]))
            $this->packaging = $this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::PACKAGING)];
    }

    private function maximumSupportedMemory(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::MAXIMUM_SUPPORTED_MEMORY)]))
            $this->maximumSupportedMemory = $this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::MAXIMUM_SUPPORTED_MEMORY)];
    }

    private function lithography(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::LITHOGRAPHY)]))
            $this->lithography =
                $this->prepareLithography($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::LITHOGRAPHY)]);
    }

    private function prepareLithography(string $lithographyString): ?string
    {
        $pattern = "~([\d.]+)\s*nm~i";
        $matches = [];
        preg_match($pattern, $lithographyString, $matches);

        if (count($matches) > 0) {
            return $matches[1];
        }

        return null;
    }

    private function cpuSeries(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::SERIES)])) {
            $series = $this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::SERIES)];
            if ($series) {
                $cpuSeries = new CpuSeries();
                $cpuSeries->setName($series);

                $this->cpuSeries = $cpuSeries;
            }
        }
    }

    private function microarchitecture(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::MICROARCHITECTURE)])) {
            $microArch = $this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::MICROARCHITECTURE)];
            if ($microArch) {
                $microArchitecture = new Microarchitecture();
                $microArchitecture->setName($microArch);

                $this->microarchitecture = $microArchitecture;
            }
        }
    }

    private function integratedGraphic(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::INTEGRATED_GRAPHICS)])) {
            $inGraphic = $this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::INTEGRATED_GRAPHICS)];
            if ($inGraphic) {
                $integratedGraphic = new IntegratedGraphic();
                $integratedGraphic->setName($inGraphic);

                $this->integratedGraphic = $integratedGraphic;
            }
        }
    }

    private function coreFamily(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::CORE_FAMILY)])) {
            $family = $this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::CORE_FAMILY)];
            if ($family) {
                $coreFamily = new CoreFamily();
                $coreFamily->setName($family);

                $this->coreFamily = $coreFamily;
            }
        }
    }

    private function lOneCache(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key((CPUExtractionEnum::L1_CACHE))])
            && is_array($this->scrapedData[CPUExtractionEnum::get_key((CPUExtractionEnum::L1_CACHE))])) {
            [$i_amount, $i_capacity, $d_amount, $d_capacity] =
                $this->prepareL1Cache($this->scrapedData[CPUExtractionEnum::get_key((CPUExtractionEnum::L1_CACHE))]);

            $lOneCache = new LOneCache();
            $lOneCache->setInstructionAmount($i_amount);
            $lOneCache->setInstructionCapacity($i_capacity);
            $lOneCache->setDataAmount($d_amount);
            $lOneCache->setDataCapacity($d_capacity);

            $this->lOneCache = $lOneCache;
        }
    }

    private function prepareL1Cache(array $instAndData): array
    {
        $dataToReturn = [null, null, null, null];
        $instruction = $instAndData[0];
        $instPattern = "~(\d+)\s*x\s*(\d+)\s*kb\sInstruction~i";
        $instMatches = [];

        preg_match($instPattern, $instruction, $instMatches);
        if (count($instMatches) > 0) {
            $dataToReturn[0] = $instMatches[1];
            $dataToReturn[1] = $instMatches[2];
        }

        $data = $instAndData[1];
        $instPattern = "~(\d+)\s*x\s*(\d+)\s*kb\sData~i";
        $dataMatches = [];

        preg_match($instPattern, $data, $dataMatches);
        if (count($dataMatches) > 0) {
            $dataToReturn[2] = $dataMatches[1];
            $dataToReturn[3] = $dataMatches[2];
        }

        return $dataToReturn;
    }

    private function lTwoCache(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::L2_CACHE)])) {
            [$amount, $capacity] =
                $this->prepareNTHCache($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::L2_CACHE)]);

            $lTwoCache = new LTwoCache();
            $lTwoCache->setAmount($amount);
            $lTwoCache->setCapacity($capacity);

            $this->lTwoCache = $lTwoCache;
        }
    }

    private function lThreeCache(): void
    {
        if (isset($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::L2_CACHE)])) {
            [$amount, $capacity] =
                $this->prepareNTHCache($this->scrapedData[CPUExtractionEnum::get_key(CPUExtractionEnum::L2_CACHE)]);

            $lThreeCache = new LThreeCache();
            $lThreeCache->setAmount($amount);
            $lThreeCache->setCapacity($capacity);

            $this->lThreeCache = $lThreeCache;
        }
    }

    private function prepareNTHCache(string $cacheString): array
    {
        $dataToReturn = [null, null];
        $pattern = "~(\d+)\s*x\s*(\d+).*~i";
        $matches = [];
        preg_match($pattern, $cacheString, $matches);

        if (count($matches) > 0) {
            $dataToReturn[0] = $matches[1];
            $dataToReturn[1] = $matches[2];
        }

        return $dataToReturn;
    }

    private function exceptionMessage(string $part): string
    {
        return "Required field: " . $part . " is absent from " . $this->name;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    /**
     * @param string|null $manufacturer
     */
    public function setManufacturer(?string $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return string|null
     */
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param string|null $model
     */
    public function setModel(?string $model): void
    {
        $this->model = $model;
    }

    /**
     * @return array|null
     */
    public function getPartNumbers(): ?array
    {
        return $this->partNumbers;
    }

    /**
     * @param array|null $partNumbers
     */
    public function setPartNumbers(?array $partNumbers): void
    {
        $this->partNumbers = $partNumbers;
    }

    /**
     * @return int|null
     */
    public function getCoreCount(): ?int
    {
        return $this->coreCount;
    }

    /**
     * @param int|null $coreCount
     */
    public function setCoreCount(?int $coreCount): void
    {
        $this->coreCount = $coreCount;
    }

    /**
     * @return float|null
     */
    public function getCoreClock(): ?float
    {
        return $this->coreClock;
    }

    /**
     * @param float|null $coreClock
     */
    public function setCoreClock(?float $coreClock): void
    {
        $this->coreClock = $coreClock;
    }

    /**
     * @return float|null
     */
    public function getBoostClock(): ?float
    {
        return $this->boostClock;
    }

    /**
     * @param float|null $boostClock
     */
    public function setBoostClock(?float $boostClock): void
    {
        $this->boostClock = $boostClock;
    }

    /**
     * @return float|null
     */
    public function getTdp(): ?float
    {
        return $this->tdp;
    }

    /**
     * @param float|null $tdp
     */
    public function setTdp(?float $tdp): void
    {
        $this->tdp = $tdp;
    }

    /**
     * @return bool|null
     */
    public function getIncludesCPUCooler(): ?bool
    {
        return $this->includesCPUCooler;
    }

    /**
     * @param bool|null $includesCPUCooler
     */
    public function setIncludesCPUCooler(?bool $includesCPUCooler): void
    {
        $this->includesCPUCooler = $includesCPUCooler;
    }

    /**
     * @return bool|null
     */
    public function getEccSupport(): ?bool
    {
        return $this->eccSupport;
    }

    /**
     * @param bool|null $eccSupport
     */
    public function setEccSupport(?bool $eccSupport): void
    {
        $this->eccSupport = $eccSupport;
    }

    /**
     * @return bool|null
     */
    public function getSmt(): ?bool
    {
        return $this->smt;
    }

    /**
     * @param bool|null $smt
     */
    public function setSmt(?bool $smt): void
    {
        $this->smt = $smt;
    }

    /**
     * @return string|null
     */
    public function getPackaging(): ?string
    {
        return $this->packaging;
    }

    /**
     * @param string|null $packaging
     */
    public function setPackaging(?string $packaging): void
    {
        $this->packaging = $packaging;
    }

    /**
     * @return float|null
     */
    public function getMaximumSupportedMemory(): ?float
    {
        return $this->maximumSupportedMemory;
    }

    /**
     * @param float|null $maximumSupportedMemory
     */
    public function setMaximumSupportedMemory(?float $maximumSupportedMemory): void
    {
        $this->maximumSupportedMemory = $maximumSupportedMemory;
    }

    /**
     * @return float|null
     */
    public function getLithography(): ?float
    {
        return $this->lithography;
    }

    /**
     * @param float|null $lithography
     */
    public function setLithography(?float $lithography): void
    {
        $this->lithography = $lithography;
    }

    /**
     * @return CpuSeries
     */
    public function getCpuSeries(): CpuSeries
    {
        return $this->cpuSeries;
    }

    /**
     * @param CpuSeries $cpuSeries
     */
    public function setCpuSeries(CpuSeries $cpuSeries): void
    {
        $this->cpuSeries = $cpuSeries;
    }

    /**
     * @return Microarchitecture
     */
    public function getMicroarchitecture(): Microarchitecture
    {
        return $this->microarchitecture;
    }

    /**
     * @param Microarchitecture $microarchitecture
     */
    public function setMicroarchitecture(Microarchitecture $microarchitecture): void
    {
        $this->microarchitecture = $microarchitecture;
    }

    /**
     * @return IntegratedGraphic
     */
    public function getIntegratedGraphic(): IntegratedGraphic
    {
        return $this->integratedGraphic;
    }

    /**
     * @param IntegratedGraphic $integratedGraphic
     */
    public function setIntegratedGraphic(IntegratedGraphic $integratedGraphic): void
    {
        $this->integratedGraphic = $integratedGraphic;
    }

    /**
     * @return CoreFamily
     */
    public function getCoreFamily(): CoreFamily
    {
        return $this->coreFamily;
    }

    /**
     * @param CoreFamily $coreFamily
     */
    public function setCoreFamily(CoreFamily $coreFamily): void
    {
        $this->coreFamily = $coreFamily;
    }

    /**
     * @return LOneCache|null
     */
    public function getLOneCache(): ?LOneCache
    {
        return $this->lOneCache;
    }

    /**
     * @param LOneCache|null $lOneCache
     */
    public function setLOneCache(?LOneCache $lOneCache): void
    {
        $this->lOneCache = $lOneCache;
    }

    /**
     * @return LTwoCache|null
     */
    public function getLTwoCache(): ?LTwoCache
    {
        return $this->lTwoCache;
    }

    /**
     * @param LTwoCache|null $lTwoCache
     */
    public function setLTwoCache(?LTwoCache $lTwoCache): void
    {
        $this->lTwoCache = $lTwoCache;
    }

    /**
     * @return LThreeCache|null
     */
    public function getLThreeCache(): ?LThreeCache
    {
        return $this->lThreeCache;
    }

    /**
     * @param LThreeCache|null $lThreeCache
     */
    public function setLThreeCache(?LThreeCache $lThreeCache): void
    {
        $this->lThreeCache = $lThreeCache;
    }
}