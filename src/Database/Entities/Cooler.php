<?php


namespace App\Database\Entities;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="App\Database\Repositories\CoolerRepository")
 * @Table(name="coolers")
 */
class Cooler
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
     * @ManyToOne(targetEntity="Manufacturer", inversedBy="coolers")
     */
    private $manufacturer;

    /**
     * @var null|string
     * @Column(type="string", name="model")
     */
    private $model;

    /**
     * @var bool
     * @Column(type="boolean", name="fanless")
     */
    private $fanless;

    /**
     * @var float
     * @Column(type="float", name="height")
     */
    private $height;

    /**
     * @var float
     * @Column(type="float", name="rpm_start")
     */
    private $rmp_start;

    /**
     * @var float
     * @Column(type="float", name="rpm_end")
     */
    private $rpm_end;

    /**
     * @var float
     * @Column(type="float", name="noise_start")
     */
    private $noise_start;

    /**
     * @var float
     * @Column(type="float", name="noise_end")
     */
    private $noise_end;

    /**
     * @var null|BearingType
     * @ManyToOne(targetEntity="BearingType", inversedBy="coolers")
     * @JoinColumn(name="bearing_type_id", referencedColumnName="id")
     */
    private $bearingType;

    /**
     * @var null|WaterCooledType
     * @ManyToOne(targetEntity="WaterCooledType", inversedBy="coolers")
     * @JoinColumn(name="water_cooled_type_id", referencedColumnName="id")
     */
    private $waterCooledType;

    /**
     * @ManyToMany(targetEntity="Color", mappedBy="coolers")
     */
    private $colors;

    /**
     * @ManyToMany(targetEntity="CpuSocket", inversedBy="coolers")
     * @JoinTable(name="coolers_cpu_sockets",
     *      joinColumns={@JoinColumn(name="cooler_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="cpu_socket_id", referencedColumnName="id")}
     *      )
     */
    private $cpuSockets;

    /**
     * @OneToMany(targetEntity="CoolerPartNumber", mappedBy="cooler")
     * @JoinColumn(name="cooler_id")
     */
    private $coolerPartNumbers;

    /**
     * @OneToMany(targetEntity="CoolerPrice", mappedBy="cooler")
     */
    private $coolerPrices;

    /**
     * @OneToMany(targetEntity="CoolerImage", mappedBy="cooler")
     */
    private $coolerImages;

    public function __construct()
    {
        $this->colors = new ArrayCollection();
        $this->cpuSockets = new ArrayCollection();
        $this->coolerPartNumbers = new ArrayCollection();
        $this->coolerPrices = new ArrayCollection();
        $this->coolerImages = new ArrayCollection();
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
     * @return null|BearingType
     */
    public function getBearingType(): ?BearingType
    {
        return $this->bearingType;
    }

    /**
     * @param null|BearingType $bearingType
     */
    public function setBearingType(?BearingType $bearingType): void
    {
        $this->bearingType = $bearingType;
    }

    /**
     * @return null|WaterCooledType
     */
    public function getWaterCooledType(): ?WaterCooledType
    {
        return $this->waterCooledType;
    }

    /**
     * @param null|WaterCooledType $waterCooledType
     */
    public function setWaterCooledType(?WaterCooledType $waterCooledType): void
    {
        $this->waterCooledType = $waterCooledType;
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
            $color->addCooler($this);
        }
    }

    /**
     * @return mixed
     */
    public function getCpuSockets()
    {
        return $this->cpuSockets;
    }

    public function addCpuSocket(CpuSocket $cpuSocket): void
    {
        if (!$this->cpuSockets->contains($cpuSocket)) {
            $this->cpuSockets[] = $cpuSocket;
            $cpuSocket->addCooler($this);
        }
    }

    /**
     * @return string
     */
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel(?string $model): void
    {
        $this->model = $model;
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
     * @return null|float
     */
    public function getHeight(): ?float
    {
        return $this->height;
    }

    /**
     * @param float $height
     */
    public function setHeight(?float $height): void
    {
        $this->height = $height;
    }

    /**
     * @return float
     */
    public function getRmpStart(): ?float
    {
        return $this->rmp_start;
    }

    /**
     * @param float $rmp_start
     */
    public function setRmpStart(?float $rmp_start): void
    {
        $this->rmp_start = $rmp_start;
    }

    /**
     * @return float
     */
    public function getRpmEnd(): ?float
    {
        return $this->rpm_end;
    }

    /**
     * @param float $rpm_end
     */
    public function setRpmEnd(?float $rpm_end): void
    {
        $this->rpm_end = $rpm_end;
    }

    /**
     * @return float
     */
    public function getNoiseStart(): ?float
    {
        return $this->noise_start;
    }

    /**
     * @param float $noise_start
     */
    public function setNoiseStart(?float $noise_start): void
    {
        $this->noise_start = $noise_start;
    }

    /**
     * @return float
     */
    public function getNoiseEnd(): ?float
    {
        return $this->noise_end;
    }

    /**
     * @param float $noise_end
     */
    public function setNoiseEnd(?float $noise_end): void
    {
        $this->noise_end = $noise_end;
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
     * @return mixed
     */
    public function getCoolerPartNumbers()
    {
        return $this->coolerPartNumbers;
    }

    public function addPartNumber(CoolerPartNumber $partNumber): void
    {
        if (!$this->coolerPartNumbers->contains($partNumber)) {
            $this->coolerPartNumbers[] = $partNumber;
            $partNumber->setCooler($this);
        }
    }

    public function getPartNumbers()
    {
        return $this->coolerPartNumbers;
    }

    /**
     * @return mixed
     */
    public function getCoolerPrices()
    {
        return $this->coolerPrices;
    }

    /**
     * @param CoolerPrice $coolerPrice
     */
    public function addCoolerPrice(CoolerPrice $coolerPrice): void
    {
        if (!$this->coolerPrices->contains($coolerPrice)) {
            $this->coolerPrices[] = $coolerPrice;
            $coolerPrice->setCooler($this);
        }
    }

    /**
     * @return mixed
     */
    public function getCoolerImages()
    {
        return $this->coolerImages;
    }

    /**
     * @param CoolerImage $coolerImage
     */
    public function addCoolerImage(CoolerImage $coolerImage): void
    {
        if (!$this->coolerImages->contains($coolerImage)) {
            $this->coolerImages[] = $coolerImage;
            $coolerImage->setCooler($this);
        }
    }
}