<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\Parts;


use App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum\GPUExtractionEnum;

class GPU
{
    const NAME = "name";
    const URL = "url";

    const AMOUNT = "amount";
    const PIN_AMOUNT = "pin_amount";
    const TYPE = "type";
    const MEASURE = "measure";

    const RADIATOR = "Radiator";
    const FAN = "Fan";

    /**
     * @var array
     */
    private $scrapedData = [];

    /**
     * @var string|null
     */
    private $name = null;

    /**
     * @var string|null
     */
    private $url = null;

    /**
     * @var string|null
     */
    private $manufacturer = null;

    /**
     * @var array|null
     */
    private $colors = [];

    /**
     * @var array|null
     */
    private $partNumbers = [];

    /**
     * @var string|null
     */
    private $chipset = null;

    /**
     * @var float|null
     */
    private $memory = null;

    /**
     * @var string|null
     */
    private $memoryType = null;

    /**
     * @var float|null
     */
    private $coreClock = null;

    /**
     * @var float|null
     */
    private $boostClock = null;

    /**
     * @var float|null
     */
    private $effectiveMemoryClock = null;

    /**
     * @var array|null
     */
    private $gpuInterface = [];

    /**
     * @var array|null
     */
    private $sliCrossfireTypes = [];

    /**
     * @var array|null
     */
    private $frameSyncTypes = [];

    /**
     * @var float|null
     */
    private $length = null;

    /**
     * @var float|null
     */
    private $tdp = null;

    /**
     * @var float|null
     */
    private $expansionSlotWidth = null;

    /**
     * @var array|null
     */
    private $externalPowerTypes = [];

    /**
     * @var array|null
     */
    private $gpuCoolingTypes = [];

    /**
     * @var array|null
     */
    private $gpuPorts = [];

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
        $this->partNumbers();
        $this->colors();
        $this->chipset();
        $this->memory();
        $this->memoryType();
        $this->coreClock();
        $this->boostClock();
        $this->effectiveMemoryClock();
        $this->gpuInterface();
        $this->sliCrossfireTypes();
        $this->frameSyncTypes();
        $this->length();
        $this->tdp();
        $this->expansionSlotWidth();
        $this->externalPowerTypes();
        $this->gpuCoolingTypes();
        $this->gpuPorts();
    }

    public function toArray(): array
    {
        $dataToReturn = [];
        $dataToReturn[self::NAME] = $this->name;
        $dataToReturn[self::URL] = $this->url;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::COLOR)] = $this->colors;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::PART_NUMBER)] = $this->partNumbers;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::MANUFACTURER)] = $this->manufacturer;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::CHIPSET)] = $this->chipset;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::MEMORY)] = $this->memory;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::MEMORY_TYPE)] = $this->memoryType;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::CORE_CLOCK)] = $this->coreClock;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::BOOST_CLOCK)] = $this->boostClock;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::EFFECTIVE_MEMORY_CLOCK)] = $this->effectiveMemoryClock;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::INTERFACE)] = $this->gpuInterface;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::SLI_CROSSFIRE)] = $this->sliCrossfireTypes;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::FRAME_SYNC)] = $this->frameSyncTypes;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::LENGTH)] = $this->length;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::TDP)] = $this->tdp;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::EXPANSION_SLOT_WIDTH)] = $this->expansionSlotWidth;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::EXTERNAL_POWER)] = $this->externalPowerTypes;
        $dataToReturn[GPUExtractionEnum::get_key(GPUExtractionEnum::COOLING)] = $this->gpuCoolingTypes;
        $dataToReturn["ports"] = $this->gpuPorts;

        return $dataToReturn;
    }

    private function name()
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
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::MANUFACTURER)]))
            $this->manufacturer = $this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::MANUFACTURER)];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(GPUExtractionEnum::MANUFACTURER));
    }

    private function partNumbers(): void
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::PART_NUMBER)]))
            $this->partNumbers = is_array($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::PART_NUMBER)])
                ? $this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::PART_NUMBER)]
                : [$this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::PART_NUMBER)]];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(GPUExtractionEnum::PART_NUMBER));
    }

    private function colors(): void
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::COLOR)]))
            $this->colors = $this->prepareColorsArray($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::COLOR)]);
    }

    private function prepareColorsArray(string $stringOfColors): array
    {
        $pattern = "~((\w+)/?(.*))+~";
        $matches = [];

        $colors = [];
        preg_match($pattern, $stringOfColors, $matches);
        if (isset($matches[2])) {
            $colors[] = $matches[2];

            while (isset($matches[3]) && $matches[3] != "") {
                preg_match($pattern, $matches[3], $matches);
                $colors[] = $matches[2];
            }
        }

        return $colors;
    }

    private function chipset(): void
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::CHIPSET)]))
            $this->chipset = $this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::CHIPSET)];
    }

    private function memory(): void
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::MEMORY)]))
            $this->memory
                = $this->prepareMemory($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::MEMORY)]);
    }

    private function prepareMemory(string $string): ?float
    {
        $pattern = "~^([\d.]+)\s*GB$~i";
        $matches = [];
        preg_match($pattern, $string, $matches);

        if (count($matches) > 0)
            return $matches[1];
        return null;
    }

    private function memoryType(): void
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::MEMORY_TYPE)]))
            $this->memoryType = $this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::MEMORY_TYPE)];
    }

    private function coreClock(): void
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::CORE_CLOCK)]))
            $this->coreClock
                = $this->prepareFloatWithoutMHz($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::CORE_CLOCK)]);
    }

    private function boostClock(): void
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::BOOST_CLOCK)]))
            $this->boostClock
                = $this->prepareFloatWithoutMHz($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::BOOST_CLOCK)]);
    }

    private function effectiveMemoryClock(): void
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::EFFECTIVE_MEMORY_CLOCK)]))
            $this->effectiveMemoryClock
                = $this->prepareFloatWithoutMHz($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::EFFECTIVE_MEMORY_CLOCK)]);
    }

    private function prepareFloatWithoutMHz(string $string): ?float
    {
        $pattern = "~^([\d.]+)\s*MHz$~i";
        $matches = [];
        preg_match($pattern, $string, $matches);

        if (count($matches) > 0)
            return $matches[1];
        return null;
    }

    private function gpuInterface(): void
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::INTERFACE)])) {
            [$type, $slotCount]
                = $this->prepareInterface($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::INTERFACE)]);

            if ($type && $slotCount)
                $this->gpuInterface[$type] = $slotCount;
        }
    }

    private function prepareInterface(string $string): array
    {
        $dataToReturn = [null, null];
        $pattern = "~^(.+)\s*x(\d+)$~i";

        $matches = [];
        preg_match($pattern, $string, $matches);

        if (count($matches) > 0) {
            $dataToReturn[0] = $matches[1];
            $dataToReturn[1] = $matches[2];
        }

        return $dataToReturn;
    }

    private function sliCrossfireTypes(): void
    {
        $sliCrossFireTypes = [];
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::SLI_CROSSFIRE)]))
            if (is_array($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::SLI_CROSSFIRE)])) {
                foreach ($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::SLI_CROSSFIRE)] as $speedType)
                    $sliCrossFireTypes[] = $speedType;
            } else
                $sliCrossFireTypes[] = $this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::SLI_CROSSFIRE)];

        $this->sliCrossfireType = $sliCrossFireTypes;
    }

    private function frameSyncTypes(): void
    {
        $frameSyncType = [];
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::FRAME_SYNC)]))
            if (is_array($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::FRAME_SYNC)])) {
                foreach ($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::FRAME_SYNC)] as $speedType)
                    $frameSyncType[] = $speedType;
            } else
                $frameSyncType[] = $this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::FRAME_SYNC)];

        $this->frameSyncTypes = $frameSyncType;
    }

    private function length(): void
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::LENGTH)]))
            $this->length =
                $this->prepareLength($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::LENGTH)]);
    }

    private function prepareLength(string $string): ?float
    {
        $pattern = "~^([\d.]+)\s*mm$~i";
        $matches = [];
        preg_match($pattern, $string, $matches);

        if (count($matches) > 0)
            return $matches[1];
        return null;
    }

    private function tdp()
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::TDP)]))
        $this->tdp =
            $this->prepareTdp($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::TDP)]);
    }

    private function prepareTdp(string $string): ?float
    {
        $pattern = "~^([\d.]+)\s*W$~i";
        $matches = [];
        preg_match($pattern, $string, $matches);

        if (count($matches) > 0)
            return $matches[1];
        return null;
    }

    private function expansionSlotWidth(): void
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::EXPANSION_SLOT_WIDTH)]))
            $this->expansionSlotWidth = $this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::EXPANSION_SLOT_WIDTH)];
    }

    private function externalPowerTypes(): void
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::EXTERNAL_POWER)]))
            $this->externalPowerTypes
                = $this->prepareExternalPowerTypes($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::EXTERNAL_POWER)]);
    }

    private function prepareExternalPowerTypes(string $externalPowerTypeString): ?array
    {
        $dataToReturn = [];
        $pattern = "~^([\w- ]+)(\s+\+\s+)?([\w- ]+)?$~i";
        $matches = [];

        preg_match($pattern, $externalPowerTypeString, $matches);

        if (count($matches) > 0) {
            $dataToReturn[] = $this->prepareSingleExternalPower($matches[1]);
            if (isset($matches[3]))
                $dataToReturn[] = $this->prepareSingleExternalPower($matches[3]);
        }

        return $dataToReturn;
    }

    private function prepareSingleExternalPower(string $string): array
    {
        $dataToReturn = [];
        $pattern = "~^(\d+)\s+(PCIe)\s+(\d+)-pin$~i";
        $matches = [];
        preg_match($pattern, $string, $matches);

        if (count($matches) > 0) {
            $dataToReturn[self::AMOUNT] = $matches[1];
            $dataToReturn[self::TYPE] = $matches[2];
            $dataToReturn[self::PIN_AMOUNT] = $matches[3];
        }

        return $dataToReturn;
    }

    private function gpuCoolingTypes(): void
    {
        if (isset($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::COOLING)]))
            $this->gpuCoolingTypes
                = $this->prepareCoolerTypes($this->scrapedData[GPUExtractionEnum::get_key(GPUExtractionEnum::COOLING)]);
    }

    private function prepareCoolerTypes(string $string): array
    {
        $dataToReturn = [];
        $pattern = "~^([\w- ]+)(\s+\+\s+)?([\w- ]+)?$~i";
        $matches = [];

        preg_match($pattern, $string, $matches);

        if (count($matches) > 0) {
            $dataToReturn[] = $this->prepareSingleCooler($matches[1]);
            if (isset($matches[3]))
                $dataToReturn[] = $this->prepareSingleCooler($matches[3]);
        }

        return $dataToReturn;
    }

    private function prepareSingleCooler(string $string): array
    {
        $dataToReturn = [];
        $pattern_radiator = "~^(\d+)\s+mm\sRadiator$~i";
        $pattern_fan = "~^(\d+)\s+Fans?$~i";
        $matches = [];

        preg_match($pattern_radiator, $string, $matches);
        if (count($matches) > 0) {
            // RADIATOR CASE
            $dataToReturn[self::TYPE] = self::RADIATOR;
            $dataToReturn[self::MEASURE] = $matches[1];
        } else {
            // FAN CASE
            preg_match($pattern_fan, $string, $matches);
            if (count($matches) > 0) {
                $dataToReturn[self::TYPE] = self::FAN;
                $dataToReturn[self::MEASURE] = $matches[1];
            }
        }

        return $dataToReturn;
    }

    private function gpuPorts(): void
    {
        foreach (GPUExtractionEnum::$gpu_ports as $key => $gpu_port) {
            if (isset($this->scrapedData[$key])) {
                $this->gpuPorts[$gpu_port] = $this->scrapedData[$key];
            }
        }
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
     * @return array|null
     */
    public function getColors(): ?array
    {
        return $this->colors;
    }

    /**
     * @param array|null $colors
     */
    public function setColors(?array $colors): void
    {
        $this->colors = $colors;
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
     * @return string|null
     */
    public function getChipset(): ?string
    {
        return $this->chipset;
    }

    /**
     * @param string|null $chipset
     */
    public function setChipset(?string $chipset): void
    {
        $this->chipset = $chipset;
    }

    /**
     * @return float|null
     */
    public function getMemory(): ?float
    {
        return $this->memory;
    }

    /**
     * @param float|null $memory
     */
    public function setMemory(?float $memory): void
    {
        $this->memory = $memory;
    }

    /**
     * @return string|null
     */
    public function getMemoryType(): ?string
    {
        return $this->memoryType;
    }

    /**
     * @param string|null $memoryType
     */
    public function setMemoryType(?string $memoryType): void
    {
        $this->memoryType = $memoryType;
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
    public function getEffectiveMemoryClock(): ?float
    {
        return $this->effectiveMemoryClock;
    }

    /**
     * @param float|null $effectiveMemoryClock
     */
    public function setEffectiveMemoryClock(?float $effectiveMemoryClock): void
    {
        $this->effectiveMemoryClock = $effectiveMemoryClock;
    }

    /**
     * @return array|null
     */
    public function getGpuInterface(): ?array
    {
        return $this->gpuInterface;
    }

    /**
     * @param array|null $gpuInterface
     */
    public function setGpuInterface(?array $gpuInterface): void
    {
        $this->gpuInterface = $gpuInterface;
    }

    /**
     * @return array|null
     */
    public function getSliCrossfireType(): ?array
    {
        return $this->sliCrossfireTypes;
    }

    /**
     * @param string|null $sliCrossfireType
     */
    public function setSliCrossfireType(?array $sliCrossfireType): void
    {
        $this->sliCrossfireType = $sliCrossfireType;
    }

    /**
     * @return array|null
     */
    public function getFrameSyncType(): ?array
    {
        return $this->frameSyncTypes;
    }

    /**
     * @param array|null $frameSyncType
     */
    public function setFrameSyncType(?array $frameSyncType): void
    {
        $this->frameSyncTypes = $frameSyncType;
    }

    /**
     * @return float|null
     */
    public function getLength(): ?float
    {
        return $this->length;
    }

    /**
     * @param float|null $length
     */
    public function setLength(?float $length): void
    {
        $this->length = $length;
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
     * @return float|null
     */
    public function getExpansionSlotWidth(): ?float
    {
        return $this->expansionSlotWidth;
    }

    /**
     * @param float|null $expansionSlotWidth
     */
    public function setExpansionSlotWidth(?float $expansionSlotWidth): void
    {
        $this->expansionSlotWidth = $expansionSlotWidth;
    }

    /**
     * @return array|null
     */
    public function getExternalPowerTypes(): ?array
    {
        return $this->externalPowerTypes;
    }

    /**
     * @param array|null $externalPowerTypes
     */
    public function setExternalPowerTypes(?array $externalPowerTypes): void
    {
        $this->externalPowerTypes = $externalPowerTypes;
    }

    /**
     * @return array|null
     */
    public function getGpuCoolingTypes(): ?array
    {
        return $this->gpuCoolingTypes;
    }

    /**
     * @param array|null $gpuCoolingTypes
     */
    public function setGpuCoolingTypes(?array $gpuCoolingTypes): void
    {
        $this->gpuCoolingTypes = $gpuCoolingTypes;
    }

    /**
     * @return array|null
     */
    public function getGpuPorts(): ?array
    {
        return $this->gpuPorts;
    }

    /**
     * @param array|null $gpuPorts
     */
    public function setGpuPorts(?array $gpuPorts): void
    {
        $this->gpuPorts = $gpuPorts;
    }

    private function exceptionMessage(string $part): string
    {
        return "Required field: " . $part . " is absent from " . $this->name;
    }
}