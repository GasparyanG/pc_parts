<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\Parts;


use App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum\MemoryExtractionEnum;

class Memory
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
     * @var null|array
     */
    private $partNumbers = [];

    /**
     * @var null|array
     */
    private $colors = [];

    /**
     * @var null||string
     */
    private $formFactor = null;

    /**
     * @var null|float
     */
    private $voltage = null;

    /**
     * @var null|string
     */
    private $type = null;

    /**
     * @var int|float
     */
    private $speed = null;

    /**
     * @var int|null
     */
    private $amount = null;

    /**
     * @var int|null
     */
    private $capacity = null;

    /**
     * @var int|null
     */
    private $casLatency = null;

    /**
     * @var string|null
     */
    private $timing = null;

    /**
     * @var string|null
     */
    private $ecc = null;

    /**
     * @var string|null
     */
    private $registered = null;

    /**
     * @var bool|null
     */
    private $heatSpreader = null;

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
        $this->formFactor();
        $this->voltage();
        $this->speed();
        $this->modules();
        $this->casLatency();
        $this->timing();
        $this->ecc_registered();
        $this->heatSpreader();
    }

    public function toArray(): array
    {
        $dataToReturn = [];
        $dataToReturn[self::NAME] = $this->name;
        $dataToReturn[self::URL] = $this->url;
        $dataToReturn[MemoryExtractionEnum::get_key(MemoryExtractionEnum::COLOR)] = $this->colors;
        $dataToReturn[MemoryExtractionEnum::get_key(MemoryExtractionEnum::FORM_FACTOR)] = $this->formFactor;
        $dataToReturn[MemoryExtractionEnum::get_key(MemoryExtractionEnum::PART_NUMBER)] = $this->partNumbers;
        $dataToReturn[MemoryExtractionEnum::get_key(MemoryExtractionEnum::VOLTAGE)] = $this->voltage;
        $dataToReturn[MemoryExtractionEnum::get_key(MemoryExtractionEnum::MANUFACTURER)] = $this->manufacturer;
        $dataToReturn[MemoryExtractionEnum::get_key(MemoryExtractionEnum::SPEED)] = $this->speed;
        $dataToReturn["type"] = $this->type;
        $dataToReturn["amount"] = $this->amount;
        $dataToReturn["capacity"] = $this->capacity;
        $dataToReturn["cas_latency"] = $this->casLatency;
        $dataToReturn[MemoryExtractionEnum::get_key(MemoryExtractionEnum::TIMING)] = $this->timing;
        $dataToReturn[MemoryExtractionEnum::get_key(MemoryExtractionEnum::HEAT_SPREADER)] = $this->heatSpreader;
        $dataToReturn["ecc"] = $this->ecc;
        $dataToReturn["registered"] = $this->registered;

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
        if (isset($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::MANUFACTURER)]))
            $this->manufacturer = $this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::MANUFACTURER)];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(MemoryExtractionEnum::MANUFACTURER));
    }

    private function partNumbers(): void
    {
        if (isset($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::PART_NUMBER)]))
            $this->partNumbers = is_array($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::PART_NUMBER)])
                ? $this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::PART_NUMBER)]
                : [$this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::PART_NUMBER)]];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(MemoryExtractionEnum::PART_NUMBER));
    }

    private function colors(): void
    {
        if (isset($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::COLOR)]))
            $this->colors = $this->prepareColorsArray($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::COLOR)]);
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

    private function formFactor(): void
    {
        if (isset($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::FORM_FACTOR)]))
            $this->formFactor = $this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::FORM_FACTOR)];
    }

    private function voltage(): void
    {
        if (isset($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::VOLTAGE)]))
            $this->voltage =
                $this->prepareVoltage($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::VOLTAGE)]);
    }

    private function prepareVoltage(string $voltageString): ?float
    {
        /**
         *  will match:
         *      15.78           v
         *  to:
         *      [0] 15.78           v
         *      [1] 15.78
         */
        $pattern = "~^([0-9.]+)\s*V?$~i";
        $matches = [];

        $dataToReturn = null;
        preg_match($pattern, $voltageString, $matches);
        if (count($matches) > 0)
            $dataToReturn = is_numeric($matches[1]) ? $matches[1]: null;

        return $dataToReturn;
    }

    private function speed(): void
    {
        if (isset($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::SPEED)]))
            [$this->type, $this->speed] =
                $this->prepareSpeedArray($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::SPEED)]);
    }

    private function prepareSpeedArray(string $speedString): array
    {
        /**
         *  will match:
         *      SpEEd DdR4 -   3200
         *  to:
         *      [0] SpEEd DdR4 -   3200
         *      [1] SpEEd
         *      [2] DdR4 - required
         *      [3] 3200 - required
         */
        $pattern = "~^(speed)?\s*(.+)\s*-\s*(\d+)$~i";
        $matches = [];

        $dataToReturn = [null, null];
        preg_match($pattern, $speedString, $matches);
        if (count($matches) > 0) {
            if (isset($matches[2]))
                $dataToReturn[0] = $matches[2] ? $matches[2] : null;
            if (isset($matches[3]))
                $dataToReturn[1] = is_numeric($matches[3]) ? $matches[3] : null;
        }

        return $dataToReturn;
    }

    private function modules(): void
    {
        if (isset($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::MODULES)]))
            [$this->amount, $this->capacity] =
                $this->prepareModulesArray($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::MODULES)]);
    }

    private function prepareModulesArray(string $modulesString): array
    {
        /**
         *  will match:
         *      2 X 8   gB
         *  to:
         *      [0] 2 X 8   gB
         *      [1] 2 - required
         *      [2] 8 - required
         */
        $pattern = "~^(\d+)\s*x\s*(\d+)\s*GB$~i";
        $matches = [];

        $dataToReturn = [null, null];
        preg_match($pattern, $modulesString, $matches);
        if (count($matches) > 0) {
            if (isset($matches[1]))
                $dataToReturn[0] = is_numeric($matches[1]) ? $matches[1] : 1;
            if (isset($matches[2]))
                $dataToReturn[1] = is_numeric($matches[2]) ? $matches[2] : null;
        }

        return $dataToReturn;
    }

    private function casLatency(): void
    {
        if (isset($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::CAS_LATENCY)]))
            $this->casLatency = $this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::CAS_LATENCY)];
    }

    private function timing(): void
    {
        if (isset($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::TIMING)]))
            $this->timing = $this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::TIMING)];
    }

    private function ecc_registered(): void
    {
        if (isset($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::ECC_REGISTERED)]))
            [$this->ecc, $this->registered] =
                $this->prepareECCRegisteredArray($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::ECC_REGISTERED)]);
    }

    private function prepareECCRegisteredArray(string $eccRegString): array
    {
        /**
         *  will match:
         *      noN-Ecc   /   Registered
         *  to:
         *      [0] noN-Ecc   /   Registered
         *      [1] noN-Ecc - required
         *      [2] Registered - required
         */
        $pattern = "~^([a-zA-Z-]+)\s*/\s*([a-zA-Z]+)$~";
        $matches = [];

        $dataToReturn = [null, null];
        preg_match($pattern, $eccRegString, $matches);
        if (count($matches) > 0) {
            if (isset($matches[1]))
                $dataToReturn[0] = $matches[1] ? $matches[1] : null;
            if (isset($matches[2]))
                $dataToReturn[1] = $matches[2] ? $matches[2] : null;
        }

        return $dataToReturn;
    }

    private function heatSpreader(): void
    {
        if (isset($this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::HEAT_SPREADER)]))
            $this->heatSpreader = $this->scrapedData[MemoryExtractionEnum::get_key(MemoryExtractionEnum::HEAT_SPREADER)] === "No" ? false : true;
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
     * @return null
     */
    public function getFormFactor()
    {
        return $this->formFactor;
    }

    /**
     * @param null $formFactor
     */
    public function setFormFactor($formFactor): void
    {
        $this->formFactor = $formFactor;
    }

    /**
     * @return float|null
     */
    public function getVoltage(): ?float
    {
        return $this->voltage;
    }

    /**
     * @param float|null $voltage
     */
    public function setVoltage(?float $voltage): void
    {
        $this->voltage = $voltage;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return float|int
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @param float|int $speed
     */
    public function setSpeed($speed): void
    {
        $this->speed = $speed;
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int|null $amount
     */
    public function setAmount(?int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int|null
     */
    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    /**
     * @param int|null $capacity
     */
    public function setCapacity(?int $capacity): void
    {
        $this->capacity = $capacity;
    }

    /**
     * @return int|null
     */
    public function getCasLatency(): ?int
    {
        return $this->casLatency;
    }

    /**
     * @param int|null $casLatency
     */
    public function setCasLatency(?int $casLatency): void
    {
        $this->casLatency = $casLatency;
    }

    /**
     * @return string|null
     */
    public function getTiming(): ?string
    {
        return $this->timing;
    }

    /**
     * @param string|null $timing
     */
    public function setTiming(?string $timing): void
    {
        $this->timing = $timing;
    }

    /**
     * @return string|null
     */
    public function getEcc(): ?string
    {
        return $this->ecc;
    }

    /**
     * @param string|null $ecc
     */
    public function setEcc(?string $ecc): void
    {
        $this->ecc = $ecc;
    }

    /**
     * @return string|null
     */
    public function getRegistered(): ?string
    {
        return $this->registered;
    }

    /**
     * @param string|null $registered
     */
    public function setRegistered(?string $registered): void
    {
        $this->registered = $registered;
    }

    /**
     * @return bool|null
     */
    public function getHeatSpreader(): ?bool
    {
        return $this->heatSpreader;
    }

    /**
     * @param bool|null $heatSpreader
     */
    public function setHeatSpreader(?bool $heatSpreader): void
    {
        $this->heatSpreader = $heatSpreader;
    }
}