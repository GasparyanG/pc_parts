<?php


namespace App\Database\Entities;


/**
 * @Entity
 * @Table(name="cpus")
 */
class Cpu
{
    /**
     * @var int
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", name="name")
     */
    private $name;

    /**
     * @var string
     * @Column(type="string", name="url")
     */
    private $url;

    /**
     * @var Manufacturer
     * @ManyToOne(targetEntity="Manufacturer", inversedBy="cpus")
     */
    private $manufacturer;

    /**
     * @var null|string
     * @Column(type="string", name="model")
     */
    private $model;

    /**
     * @var null|int
     * @Column(type="integer", name="core_count")
     */
    private $coreCount;

    /**
     * @var float|null
     * @Column(type="float", name="core_clock")
     */
    private $coreClock;

    /**
     * @var float|null
     * @Column(type="float", name="boost_clock")
     */
    private $boostClock;

    /**
     * @var float|null
     * @Column(type="float", name="tdp")
     */
    private $tdp;

    /**
     * @var bool|null
     * @Column(type="boolean", name="includes_cpu_cooler")
     */
    private $includesCpuCooler;

    /**
     * @var bool|null
     * @Column(type="boolean", name="ecc_support")
     */
    private $eccSupport;

    /**
     * @var bool|null
     * @Column(type="boolean", name="smt")
     */
    private $smt;

    /**
     * @var string
     * @Column(type="string", name="packaging")
     */
    private $packaging;

    /**
     * @var float|null
     * @Column(type="float", name="maximum_supported_memory")
     */
    private $maximumSupportedMemory;

    /**
     * @var float|null
     * @Column(type="float", name="lithography")
     */
    private $lithography;

    /**
     * @var CpuSeries
     * @ManyToOne(targetEntity="CpuSeries", inversedBy="cpus")
     * @JoinColumn(name="cpu_series_id")
     */
    private $cpuSeries;

    /**
     * @var Microarchitecture
     * @ManyToOne(targetEntity="Microarchitecture", inversedBy="cpus")
     */
    private $microarchitecture;

    /**
     * @var IntegratedGraphic
     * @ManyToOne(targetEntity="IntegratedGraphic", inversedBy="cpus")
     * @JoinColumn(name="integrated_graphic_id")
     */
    private $integratedGraphic;

    /**
     * @var CoreFamily
     * @ManyToOne(targetEntity="CoreFamily", inversedBy="cpus")
     * @JoinColumn(name="core_family_id")
     */
    private $coreFamily;

    /**
     * @var LOneCache|null
     * @ManyToOne(targetEntity="LOneCache", inversedBy="cpus")
     * @JoinColumn(name="l_one_cache_id")
     */
    private $lOneCache;

    /**
     * @var LTwoCache|null
     * @ManyToOne(targetEntity="LTwoCache", inversedBy="cpus")
     * @JoinColumn(name="l_two_cache_id")
     */
    private $lTwoCache;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return Manufacturer
     */
    public function getManufacturer(): Manufacturer
    {
        return $this->manufacturer;
    }

    /**
     * @param Manufacturer $manufacturer
     */
    public function setManufacturer(Manufacturer $manufacturer): void
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
    public function getIncludesCpuCooler(): ?bool
    {
        return $this->includesCpuCooler;
    }

    /**
     * @param bool|null $includesCpuCooler
     */
    public function setIncludesCpuCooler(?bool $includesCpuCooler): void
    {
        $this->includesCpuCooler = $includesCpuCooler;
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
     * @return string
     */
    public function getPackaging(): string
    {
        return $this->packaging;
    }

    /**
     * @param string $packaging
     */
    public function setPackaging(string $packaging): void
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
    public function getCpuSeries(): ?CpuSeries
    {
        return $this->cpuSeries;
    }

    /**
     * @param CpuSeries $cpuSeries
     */
    public function setCpuSeries(?CpuSeries $cpuSeries): void
    {
        $this->cpuSeries = $cpuSeries;
    }

    /**
     * @return Microarchitecture
     */
    public function getMicroarchitecture(): ?Microarchitecture
    {
        return $this->microarchitecture;
    }

    /**
     * @param Microarchitecture $microarchitecture
     */
    public function setMicroarchitecture(?Microarchitecture $microarchitecture): void
    {
        $this->microarchitecture = $microarchitecture;
    }

    /**
     * @return IntegratedGraphic
     */
    public function getIntegratedGraphic(): ?IntegratedGraphic
    {
        return $this->integratedGraphic;
    }

    /**
     * @param IntegratedGraphic $integratedGraphic
     */
    public function setIntegratedGraphic(?IntegratedGraphic $integratedGraphic): void
    {
        $this->integratedGraphic = $integratedGraphic;
    }

    /**
     * @return CoreFamily
     */
    public function getCoreFamily(): ?CoreFamily
    {
        return $this->coreFamily;
    }

    /**
     * @param CoreFamily $coreFamily
     */
    public function setCoreFamily(?CoreFamily $coreFamily): void
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
}