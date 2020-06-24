<?php


namespace App\Database\Entities;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="memories")
 */
class Memory
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
     * @var float
     * @Column(type="float", name="speed")
     */
    private $speed;

    /**
     * @var string
     * @Column(type="string", name="type")
     */
    private $type;

    /**
     * @var Manufacturer
     * @ManyToOne(targetEntity="Manufacturer", inversedBy="memories")
     */
    private $manufacturer;

    /**
     * @var null|FormFactor
     * @ManyToOne(targetEntity="FormFactor", inversedBy="memories")
     * @JoinColumn(name="form_factor_id", referencedColumnName="id")
     */
    private $formFactor;

    /**
     * @var null|Module
     * @ManyToOne(targetEntity="Module", inversedBy="memories")
     * @JoinColumn(name="modules_id", referencedColumnName="id")
     */
    private $module;

    /**
     * @var Timing|null
     * @ManyToOne(targetEntity="Timing", inversedBy="memories")
     */
    private $timing;

    /**
     * @var null|EccRegister
     * @ManyToOne(targetEntity="ECCRegister", inversedBy="memories")
     * @JoinColumn(name="ecc_register_id", referencedColumnName="id")
     */
    private $eccRegister;

    /**
     * @var float
     * @Column(type="float", name="voltage")
     */
    private $voltage;

    /**
     * @var bool
     * @Column(type="boolean", name="heat_spreader")
     */
    private $heatSpreader;

    /**
     * @OneToMany(targetEntity="MemoryPartNumber", mappedBy="memory")
     */
    private $memoryPartNumbers;

    /**
     * @ManyToMany(targetEntity="Color", mappedBy="memories")
     */
    private $colors;

    /**
     * @OneToMany(targetEntity="MemoryPrice", mappedBy="memory")
     */
    private $memoryPrices;

    public function __construct()
    {
        $this->memoryPartNumbers = new ArrayCollection();
        $this->colors = new ArrayCollection();
        $this->memoryPrices = new ArrayCollection();
    }

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
     * @return float
     */
    public function getSpeed(): float
    {
        return $this->speed;
    }

    /**
     * @param float $speed
     */
    public function setSpeed(float $speed): void
    {
        $this->speed = $speed;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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
     * @return FormFactor|null
     */
    public function getFormFactor(): ?FormFactor
    {
        return $this->formFactor;
    }

    /**
     * @param FormFactor|null $formFactor
     */
    public function setFormFactor(?FormFactor $formFactor): void
    {
        $this->formFactor = $formFactor;
    }

    /**
     * @return Module|null
     */
    public function getModule(): ?Module
    {
        return $this->module;
    }

    /**
     * @param Module|null $module
     */
    public function setModule(?Module $module): void
    {
        $this->module = $module;
    }

    /**
     * @return Timing|null
     */
    public function getTiming(): ?Timing
    {
        return $this->timing;
    }

    /**
     * @param Timing|null $timing
     */
    public function setTiming(?Timing $timing): void
    {
        $this->timing = $timing;
    }

    /**
     * @return EccRegister|null
     */
    public function getEccRegister(): ?EccRegister
    {
        return $this->eccRegister;
    }

    /**
     * @param EccRegister|null $eccRegister
     */
    public function setEccRegister(?EccRegister $eccRegister): void
    {
        $this->eccRegister = $eccRegister;
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
     * @return bool
     */
    public function isHeatSpreader(): bool
    {
        return $this->heatSpreader;
    }

    /**
     * @param bool $heatSpreader
     */
    public function setHeatSpreader(bool $heatSpreader): void
    {
        $this->heatSpreader = $heatSpreader;
    }

    /**
     * @return mixed
     */
    public function getMemoryPartNumbers()
    {
        return $this->memoryPartNumbers;
    }

    public function addMemoryPartNumber(MemoryPartNumber $mpn): void
    {
        if (!$this->memoryPartNumbers->contains($mpn)) {
            $this->memoryPartNumbers[] = $mpn;
            $mpn->setMemory($this);
        }
    }

    public function getPartNumbers()
    {
        return $this->memoryPartNumbers;
    }

    /**
     * @return mixed
     */
    public function getColors()
    {
        return $this->colors;
    }

    public function addColor(Color $color): void
    {
        if(!$this->colors->contains($color)) {
            $this->colors[] = $color;
            $color->addMemory($this);
        }
    }

    /**
     * @return mixed
     */
    public function getMemoryPrices()
    {
        return $this->memoryPrices;
    }

    /**
     * @param StoragePrice $storagePrice
     */
    public function addMemoryPrice(MemoryPrice $memoryPrice): void
    {
        if (!$this->memoryPrices->contains($memoryPrice)) {
            $this->memoryPrices[] = $memoryPrice;
            $memoryPrice->setMemory($this);
        }
    }
}