<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\Parts;


use App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum\CoolerExtractionEnum;

class Cooler
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
     * @var null|float
     */
    private $fanRpmStart = null;

    /**
     * @var null|float
     */
    private $fanRpmEnd = null;

    /**
     * @var null|float
     */
    private $noiseLevelStart = null;

    /**
     * @var null|float
     */
    private $noiseLevelEnd = null;

    /**
     * @var null|array
     */
    private $colors = [];

    /**
     * @var null|array
     */
    private $cpuSockets = [];

    /**
     * @var null|string
     */
    private $waterCooled = null;

    /**
     * @var bool
     */
    private $fanless = false;

    /**
     * @var null|float
     */
    private $height = null;

    /**
     * @var null|string
     */
    private $bearingType = null;

    /**
     * Cooler constructor.
     * @param array $scrapedData
     */
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
        $this->fanRpm();
        $this->noiseLevel();
        $this->colors();
        $this->cpuSockets();
        $this->waterCooled();
        $this->fanless();
        $this->height();
        $this->bearingType();
    }

    public function toArray()
    {
        $dataToReturn = [];
        $dataToReturn[self::NAME] = $this->name;
        $dataToReturn[self::URL] = $this->url;
        $dataToReturn[CoolerExtractionEnum::get_key(CoolerExtractionEnum::HEIGHT)] = $this->height;
        $dataToReturn[CoolerExtractionEnum::get_key(CoolerExtractionEnum::COLOR)] = $this->colors;
        $dataToReturn[CoolerExtractionEnum::get_key(CoolerExtractionEnum::FANLESS)] = $this->fanless;
        $dataToReturn[CoolerExtractionEnum::get_key(CoolerExtractionEnum::PART_NUMBER)] = $this->partNumbers;
        $dataToReturn[CoolerExtractionEnum::get_key(CoolerExtractionEnum::BEARING_TYPE)] = $this->bearingType;
        $dataToReturn[CoolerExtractionEnum::get_key(CoolerExtractionEnum::WATER_COOLED)] = $this->waterCooled;
        $dataToReturn["start_noise"] = $this->noiseLevelStart;
        $dataToReturn["end_noise"] = $this->noiseLevelEnd;
        $dataToReturn["start_dan_rpm"] = $this->fanRpmStart;
        $dataToReturn["end_dan_rpm"] = $this->fanRpmEnd;
        $dataToReturn[CoolerExtractionEnum::get_key(CoolerExtractionEnum::MODEL)] = $this->model;
        $dataToReturn[CoolerExtractionEnum::get_key(CoolerExtractionEnum::MANUFACTURER)] = $this->manufacturer;
        $dataToReturn[CoolerExtractionEnum::get_key(CoolerExtractionEnum::HEIGHT)] = $this->height;
        $dataToReturn[CoolerExtractionEnum::get_key(CoolerExtractionEnum::CPU_SOCKET)] = $this->cpuSockets;

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
        if (isset($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::MANUFACTURER)]))
            $this->manufacturer = $this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::MANUFACTURER)];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(CoolerExtractionEnum::MANUFACTURER));
    }

    private function model(): void
    {
        if (isset($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::MODEL)]))
            $this->model = $this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::MODEL)];
    }

    private function partNumbers(): void
    {
        if (isset($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::PART_NUMBER)]))
            $this->partNumbers = is_array($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::PART_NUMBER)])
                ? $this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::PART_NUMBER)]
                : [$this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::PART_NUMBER)]];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(CoolerExtractionEnum::PART_NUMBER));
    }

    private function fanRpm(): void
    {
        if (isset($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::FAN_RPM)]))
            [$this->fanRpmStart, $this->fanRpmEnd] =
                $this->prepareFanRpmArray($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::FAN_RPM)]);
    }

    private function prepareFanRpmArray(string $fanRpm): array
    {
        $pattern = "~(\d+)([- ]+)?(\d+)?\s*\w{2}~";
        $matches = [];
        preg_match($pattern, $fanRpm, $matches);

        $dataToReturn = [null, null];
        if (count($matches) > 0) {
            if (isset($matches[1]) && isset($matches[3])) {
                $dataToReturn[0] = is_numeric($matches[1]) ? $matches[1] : null;
                $dataToReturn[1] = is_numeric($matches[3]) ? $matches[3] : null;
            } else if (isset($matches[1]))
                $dataToReturn[1] = is_numeric($matches[1]) ? $matches[1] : null;
        }

        return $dataToReturn;
    }

    private function noiseLevel(): void
    {
        if (isset($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::NOISE_LEVEL)]))
            [$this->noiseLevelStart, $this->noiseLevelEnd] =
                $this->prepareNoiseLevelArray($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::NOISE_LEVEL)]);
    }

    private function prepareNoiseLevelArray(string $noiseLevel): array
    {
        $pattern = "~(\d+)(\s*-\s*)?(\d+)?\s*\w{2}~";;
        $matches = [];
        preg_match($pattern, $noiseLevel, $matches);

        $dataToReturn = [null, null];
        if (count($matches) > 0) {
            if (isset($matches[1]) && isset($matches[3])) {
                $dataToReturn[0] = is_numeric($matches[1]) ? $matches[1] : null;
                $dataToReturn[1] = is_numeric($matches[3]) ? $matches[3] : null;
            } else if (isset($matches[1]))
                $dataToReturn[1] = is_numeric($matches[1]) ? $matches[1] : null;
        }

        return $dataToReturn;
    }

    private function colors(): void
    {
        if (isset($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::COLOR)]))
            $this->colors = $this->prepareColorsArray($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::COLOR)]);
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

    private function cpuSockets(): void
    {
        if (isset($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::CPU_SOCKET)]))
            $this->cpuSockets = is_array($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::CPU_SOCKET)])
                ? $this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::CPU_SOCKET)]
                : [$this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::CPU_SOCKET)]];
    }

    private function waterCooled(): void
    {
        if (isset($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::WATER_COOLED)]))
            $this->waterCooled = $this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::WATER_COOLED)];
    }

    private function fanless(): void
    {
        if (isset($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::FANLESS)]))
            $this->fanless = $this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::FANLESS)] === "No" ? false : true;
    }

    private function height(): void
    {
        if (isset($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::HEIGHT)]))
            $this->height = $this->prepareHeight($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::HEIGHT)]);
    }

    private function prepareHeight(string $height): ?float
    {
        $matches = [];
        $pattern = "~^(\d+)\s*\w{2}$~";
        preg_match($pattern, $height, $matches);

        return $matches[2] ?? null;
    }

    private function bearingType(): void
    {
        if (isset($this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::BEARING_TYPE)]))
            $this->bearingType = $this->scrapedData[CoolerExtractionEnum::get_key(CoolerExtractionEnum::BEARING_TYPE)];
    }

    private function exceptionMessage(string $part): string
    {
        return "Required filed: " . $part . " is absent from " . $this->name;
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
     * @return float|null
     */
    public function getFanRpmStart(): ?float
    {
        return $this->fanRpmStart;
    }

    /**
     * @param float|null $fanRpmStart
     */
    public function setFanRpmStart(?float $fanRpmStart): void
    {
        $this->fanRpmStart = $fanRpmStart;
    }

    /**
     * @return float|null
     */
    public function getFanRpmEnd(): ?float
    {
        return $this->fanRpmEnd;
    }

    /**
     * @param float|null $fanRpmEnd
     */
    public function setFanRpmEnd(?float $fanRpmEnd): void
    {
        $this->fanRpmEnd = $fanRpmEnd;
    }

    /**
     * @return float|null
     */
    public function getNoiseLevelStart(): ?float
    {
        return $this->noiseLevelStart;
    }

    /**
     * @param float|null $noiseLevelStart
     */
    public function setNoiseLevelStart(?float $noiseLevelStart): void
    {
        $this->noiseLevelStart = $noiseLevelStart;
    }

    /**
     * @return float|null
     */
    public function getNoiseLevelEnd(): ?float
    {
        return $this->noiseLevelEnd;
    }

    /**
     * @param float|null $noiseLevelEnd
     */
    public function setNoiseLevelEnd(?float $noiseLevelEnd): void
    {
        $this->noiseLevelEnd = $noiseLevelEnd;
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
    public function getCpuSockets(): ?array
    {
        return $this->cpuSockets;
    }

    /**
     * @param array|null $cpuSockets
     */
    public function setCpuSockets(?array $cpuSockets): void
    {
        $this->cpuSockets = $cpuSockets;
    }

    /**
     * @return string|null
     */
    public function getWaterCooled(): ?string
    {
        return $this->waterCooled;
    }

    /**
     * @param string|null $waterCooled
     */
    public function setWaterCooled(?string $waterCooled): void
    {
        $this->waterCooled = $waterCooled;
    }

    /**
     * @return bool
     */
    public function isFanless(): bool
    {
        return $this->fanless;
    }

    /**
     * @param bool $fanless
     */
    public function setFanless(bool $fanless): void
    {
        $this->fanless = $fanless;
    }

    /**
     * @return float|null
     */
    public function getHeight(): ?float
    {
        return $this->height;
    }

    /**
     * @param float|null $height
     */
    public function setHeight(?float $height): void
    {
        $this->height = $height;
    }

    /**
     * @return string|null
     */
    public function getBearingType(): ?string
    {
        return $this->bearingType;
    }

    /**
     * @param string|null $bearingType
     */
    public function setBearingType(?string $bearingType): void
    {
        $this->bearingType = $bearingType;
    }
}