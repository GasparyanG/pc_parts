<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\Parts;


use App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum\MOBOExtractionEnum;

class MOBO
{
    const NAME = "name";
    const URL = "url";
    const USB = "usb";
    const PCI_E = "pci_e";
    const SATA = "sata_types";

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
     * @var string|null
     */
    private $cpuSocket = null;

    /**
     * @var string|null
     */
    private $chipset;

    /**
     * @var float|null
     */
    private $maxMemory = null;

    /**
     * @var string|null
     */
    private $memoryType = null;

    /**
     * @var int|null
     */
    private $memorySlots = null;

    /**
     * @var string|null
     */
    private $onboardVideo = null;

    /**
     * @var bool|null
     */
    private $supportsEcc = null;

    /**
     * @var string|null
     */
    private $wirelessNetworkingType = null;

    /**
     * @var array|null
     */
    private $moboMemorySpeedTypes = [];

    /**
     * @var array|null
     */
    private $sliCrossfireTypes = [];

    /**
     * @var array|null
     */
    private $usbs = [];

    /**
     * @var array|null
     */
    private $mDot2Types = [];

    /**
     * @var array|null
     */
    private $onboardEthernetTypes = [];

    /**
     * @var null|array
     */
    private $pcies = [];

    /**
     * @var bool|null
     */
    private $raidSupport = null;

    /**
     * @var int|null
     */
    private $pciSlots = null;

    /**
     * @var int|null
     */
    private $mSataSlots = null;

    /**
     * @var int|null
     */
    private $sataExpress = null;

    /**
     * @var array|null
     */
    private $motherboardSataTypes = [];

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
        $this->cpuSocket();
        $this->chipset();
        $this->maxMemory();
        $this->memoryType();
        $this->memorySlots();
        $this->onboardVideo();
        $this->supportsEcc();
        $this->wirelessNetworkingType();
        $this->moboMemorySpeedTypes();
        $this->sliCrossfireTypes();
        $this->usbs();
        $this->mDot2Types();
        $this->onboardEthernetTypes();
        $this->pcies();
        $this->raidSupport();
        $this->pciSlots();
        $this->mSataSlots();
        $this->sataExpress();
        $this->motherboardSataTypes();
    }

    public function toArray(): array
    {
        $dataToReturn = [];
        $dataToReturn[self::NAME] = $this->name;
        $dataToReturn[self::URL] = $this->url;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::COLOR)] = $this->colors;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::FORM_FACTOR)] = $this->formFactor;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::PART_NUMBER)] = $this->partNumbers;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MANUFACTURER)] = $this->manufacturer;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::CPU_SOCKET)] = $this->cpuSocket;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::CHIPSET)] = $this->chipset;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_MAX)] = $this->maxMemory;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_TYPE)] = $this->memoryType;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_SLOTS)] = $this->memorySlots;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::ONBOARD_VIDEO)] = $this->onboardVideo;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::SUPPORTS_ECC)] = $this->supportsEcc;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::WIRELESS_NETWORKING)] = $this->wirelessNetworkingType;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_SPEED)] = $this->moboMemorySpeedTypes;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::SLI_CROSSFIRE)] = $this->sliCrossfireTypes;
        $dataToReturn[self::USB] = $this->usbs;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::M_DOT_2)] = $this->mDot2Types;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::ONBOARD_ETHERNET)] = $this->onboardEthernetTypes;
        $dataToReturn[self::PCI_E] = $this->pcies;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::RAID_SUPPORT)] = $this->raidSupport;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::PCI)] = $this->pciSlots;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::M_SATA)] = $this->mSataSlots;
        $dataToReturn[MOBOExtractionEnum::get_key(MOBOExtractionEnum::SATA_EXPRESS)] = $this->sataExpress;
        $dataToReturn[self::SATA] = $this->motherboardSataTypes;

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
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MANUFACTURER)]))
            $this->manufacturer = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MANUFACTURER)];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(MOBOExtractionEnum::MANUFACTURER));
    }

    private function partNumbers(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::PART_NUMBER)]))
            $this->partNumbers = is_array($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::PART_NUMBER)])
                ? $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::PART_NUMBER)]
                : [$this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::PART_NUMBER)]];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(MOBOExtractionEnum::PART_NUMBER));
    }

    private function colors(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::COLOR)]))
            $this->colors = $this->prepareColorsArray($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::COLOR)]);
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
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::FORM_FACTOR)]))
            $this->formFactor = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::FORM_FACTOR)];
    }

    private function cpuSocket(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::CPU_SOCKET)]))
            $this->cpuSocket = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::CPU_SOCKET)];
    }

    private function exceptionMessage(string $part): string
    {
        return "Required field: " . $part . " is absent from " . $this->name;
    }

    private function chipset(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::CHIPSET)]))
            $this->chipset = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::CHIPSET)];
    }

    private function maxMemory(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_MAX)]))
            $this->maxMemory =
                $this->prepareMaxMemory($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_MAX)]);
    }

    private function prepareMaxMemory(string $string): ?float
    {
        $pattern = "~^([\d.]+)\s*GB~i";
        $matches = [];

        preg_match($pattern, $string, $matches);
        if (count($matches) > 0)
            return $matches[1];
        return null;
    }

    private function memoryType(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_TYPE)]))
            $this->memoryType = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_TYPE)];
    }

    private function memorySlots(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_SLOTS)]))
            $this->memorySlots = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_SLOTS)];
    }

    private function onboardVideo(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::ONBOARD_VIDEO)]))
            $this->onboardVideo = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::ONBOARD_VIDEO)];
    }

    private function supportsEcc()
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::SUPPORTS_ECC)]))
            $this->supportsEcc = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::SUPPORTS_ECC)] === "NO" ? false : true;
    }

    private function wirelessNetworkingType(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::WIRELESS_NETWORKING)]))
            $this->wirelessNetworkingType = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::WIRELESS_NETWORKING)];
    }

    private function moboMemorySpeedTypes(): void
    {
        $memorySpeedTypes = [];
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_SPEED)])) {
            if (is_array($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_SPEED)])) {
                foreach ($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_SPEED)] as $speedType) {
                    [$type, $speed] = $this->prepareSpeedType($speedType);
                    if ($type && $speed)
                        $memorySpeedTypes[$type] = $speed;
                }
            } else {
                [$type, $speed] = $this->prepareSpeedType($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::MEMORY_SPEED)]);
                if ($type && $speed)
                    $memorySpeedTypes[$type] = $speed;
            }
        }

        $this->moboMemorySpeedTypes = $memorySpeedTypes;
    }

    private function prepareSpeedType(string $speedType): array
    {
        $pattern = "~^(\w+)\s*-\s*(\d+)$~i";
        $matches = [];

        $speedTypeResult = [null, null];
        preg_match($pattern, $speedType, $matches);
        if (count($matches) > 0) {
            $speedTypeResult[0] = $matches[1];
            $speedTypeResult[1] = $matches[2];
        }

        return $speedTypeResult;
    }

    private function sliCrossfireTypes(): void
    {
        $sliCrossFireTypes = [];
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::SLI_CROSSFIRE)]))
            if (is_array($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::SLI_CROSSFIRE)])) {
                foreach ($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::SLI_CROSSFIRE)] as $speedType)
                    $sliCrossFireTypes[] = $speedType;
            } else
                $sliCrossFireTypes[] = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::SLI_CROSSFIRE)];

        $this->sliCrossfireTypes = $sliCrossFireTypes;
    }

    private function usbs(): void
    {
        $USBs = [];
        foreach (MOBOExtractionEnum::usb_headers() as $header)
            if (isset($this->scrapedData[$header]))
                $USBs[$header] = $this->scrapedData[$header];

        $this->usbs = $USBs;
    }

    private function mDot2Types()
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::M_DOT_2)])) {
            if (is_array($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::M_DOT_2)])) {
                foreach ($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::M_DOT_2)] as $md2) {
                    [$key, $array] = $this->prepareMDot2($md2);
                    if ($key && $array)
                        $this->mDot2Types[$key] = $array;
                }
            } else {
                [$key, $array] = $this->prepareMDot2($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::M_DOT_2)]);
                if ($key && $array)
                    $this->mDot2Types[$key] = $array;
            }
        }
    }

    private function prepareMDot2(string $mDot2String): array
    {
        $dataToReturn = [null, []];

        // extracting parts
        $extraction_pattern = "~(.+)\s(\w{1}-key)~i";
        $matches = [];

        preg_match($extraction_pattern, $mDot2String, $matches);
        if (!count($matches))
            return $dataToReturn;

        // prepare key
        $key = $matches[2];
        $dataToReturn[0] = $key;

        // prepare sizes
        $dataToReturn[1] = $this->prepareColorsArray($matches[1]);

        return $dataToReturn;
    }

    private function onboardEthernetTypes(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::ONBOARD_ETHERNET)])) {
            if (is_array($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::ONBOARD_ETHERNET)])) {
                foreach ($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::ONBOARD_ETHERNET)] as $ethType) {
                    [$amount, $speed] = $this->prepareEthType($ethType);
                    if ($amount && $speed)
                        $this->onboardEthernetTypes[] = [$amount, $speed];
                }
            } else {
                [$amount, $speed] = $this->prepareEthType($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::ONBOARD_ETHERNET)]);
                if ($amount && $speed)
                    $this->onboardEthernetTypes[] = [$amount, $speed];
            }
        }
    }

    private function prepareEthType(string $ethType): array
    {
        $dataToReturn = [null, null];
        $pattern = "~^([\d.]+)\s*x\s*([\d.]+)\s*(Mbit|Gbit)/s$~i";
        $matches = [];

        preg_match($pattern, $ethType, $matches);
        if (count($matches) > 0) {
            $amount = $matches[1];
            $size = $matches[2];
            if (strtolower($matches[3]) === "gbit")
                $size *= 1000;

            $dataToReturn[0] = $amount;
            $dataToReturn[1] = $size;
        }

        return $dataToReturn;
    }

    private function pcies(): void
    {
        $PCIEs = [];
        foreach (MOBOExtractionEnum::pcies() as $pcie)
            if (isset($this->scrapedData[$pcie]))
                $PCIEs[$pcie] = $this->scrapedData[$pcie];

        $this->pcies = $PCIEs;
    }

    private function raidSupport(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::RAID_SUPPORT)]))
            $this->raidSupport = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::RAID_SUPPORT)] === "NO" ? false : true;
    }

    private function pciSlots(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::PCI)]))
            $this->pciSlots = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::PCI)];
    }

    private function mSataSlots(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::M_SATA)]))
            $this->mSataSlots = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::M_SATA)];
    }

    private function sataExpress(): void
    {
        if (isset($this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::SATA_EXPRESS)]))
            $this->sataExpress = $this->scrapedData[MOBOExtractionEnum::get_key(MOBOExtractionEnum::SATA_EXPRESS)];
    }

    private function motherboardSataTypes(): void
    {
        $SATAs = [];
        foreach (MOBOExtractionEnum::sata_types() as $sata)
            if (isset($this->scrapedData[$sata]))
                $SATAs[$sata] = $this->scrapedData[$sata];

        $this->motherboardSataTypes = $sata;
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
     * @return string|null
     */
    public function getCpuSocket(): ?string
    {
        return $this->cpuSocket;
    }

    /**
     * @param string|null $cpuSocket
     */
    public function setCpuSocket(?string $cpuSocket): void
    {
        $this->cpuSocket = $cpuSocket;
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
    public function getMaxMemory(): ?float
    {
        return $this->maxMemory;
    }

    /**
     * @param float|null $maxMemory
     */
    public function setMaxMemory(?float $maxMemory): void
    {
        $this->maxMemory = $maxMemory;
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
     * @return int|null
     */
    public function getMemorySlots(): ?int
    {
        return $this->memorySlots;
    }

    /**
     * @param int|null $memorySlots
     */
    public function setMemorySlots(?int $memorySlots): void
    {
        $this->memorySlots = $memorySlots;
    }

    /**
     * @return string|null
     */
    public function getOnboardVideo(): ?string
    {
        return $this->onboardVideo;
    }

    /**
     * @param string|null $onboardVideo
     */
    public function setOnboardVideo(?string $onboardVideo): void
    {
        $this->onboardVideo = $onboardVideo;
    }

    /**
     * @return bool|null
     */
    public function getSupportsEcc(): ?bool
    {
        return $this->supportsEcc;
    }

    /**
     * @param bool|null $supportsEcc
     */
    public function setSupportsEcc(?bool $supportsEcc): void
    {
        $this->supportsEcc = $supportsEcc;
    }

    /**
     * @return string|null
     */
    public function getWirelessNetworkingType(): ?string
    {
        return $this->wirelessNetworkingType;
    }

    /**
     * @param string|null $wirelessNetworkingType
     */
    public function setWirelessNetworkingType(?string $wirelessNetworkingType): void
    {
        $this->wirelessNetworkingType = $wirelessNetworkingType;
    }

    /**
     * @return array|null
     */
    public function getMoboMemorySpeedTypes(): ?array
    {
        return $this->moboMemorySpeedTypes;
    }

    /**
     * @param array|null $moboMemorySpeedTypes
     */
    public function setMoboMemorySpeedTypes(?array $moboMemorySpeedTypes): void
    {
        $this->moboMemorySpeedTypes = $moboMemorySpeedTypes;
    }

    /**
     * @return array|null
     */
    public function getSliCrossfireTypes(): ?array
    {
        return $this->sliCrossfireTypes;
    }

    /**
     * @param array|null $sliCrossfireTypes
     */
    public function setSliCrossfireTypes(?array $sliCrossfireTypes): void
    {
        $this->sliCrossfireTypes = $sliCrossfireTypes;
    }

    /**
     * @return array|null
     */
    public function getUsbs(): ?array
    {
        return $this->usbs;
    }

    /**
     * @param array|null $usbs
     */
    public function setUsbs(?array $usbs): void
    {
        $this->usbs = $usbs;
    }

    /**
     * @return array|null
     */
    public function getMDot2Types(): ?array
    {
        return $this->mDot2Types;
    }

    /**
     * @param array|null $mDot2Types
     */
    public function setMDot2Types(?array $mDot2Types): void
    {
        $this->mDot2Types = $mDot2Types;
    }

    /**
     * @return array|null
     */
    public function getOnboardEthernetTypes(): ?array
    {
        return $this->onboardEthernetTypes;
    }

    /**
     * @param array|null $onboardEthernetTypes
     */
    public function setOnboardEthernetTypes(?array $onboardEthernetTypes): void
    {
        $this->onboardEthernetTypes = $onboardEthernetTypes;
    }

    /**
     * @return array|null
     */
    public function getPcies(): ?array
    {
        return $this->pcies;
    }

    /**
     * @param array|null $pcies
     */
    public function setPcies(?array $pcies): void
    {
        $this->pcies = $pcies;
    }

    /**
     * @return bool|null
     */
    public function getRaidSupport(): ?bool
    {
        return $this->raidSupport;
    }

    /**
     * @param bool|null $raidSupport
     */
    public function setRaidSupport(?bool $raidSupport): void
    {
        $this->raidSupport = $raidSupport;
    }

    /**
     * @return int|null
     */
    public function getPciSlots(): ?int
    {
        return $this->pciSlots;
    }

    /**
     * @param int|null $pciSlots
     */
    public function setPciSlots(?int $pciSlots): void
    {
        $this->pciSlots = $pciSlots;
    }

    /**
     * @return int|null
     */
    public function getMSataSlots(): ?int
    {
        return $this->mSataSlots;
    }

    /**
     * @param int|null $mSataSlots
     */
    public function setMSataSlots(?int $mSataSlots): void
    {
        $this->mSataSlots = $mSataSlots;
    }

    /**
     * @return int|null
     */
    public function getSataExpress(): ?int
    {
        return $this->sataExpress;
    }

    /**
     * @param int|null $sataExpress
     */
    public function setSataExpress(?int $sataExpress): void
    {
        $this->sataExpress = $sataExpress;
    }

    /**
     * @return array|null
     */
    public function getMotherboardSataTypes(): ?array
    {
        return $this->motherboardSataTypes;
    }

    /**
     * @param array|null $motherboardSataTypes
     */
    public function setMotherboardSataTypes(?array $motherboardSataTypes): void
    {
        $this->motherboardSataTypes = $motherboardSataTypes;
    }
}