<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="App\Database\Repositories\VideoCardRepository")
 * @Table(name="video_cards")
 */
class VideoCard 
{
    const IMAGE_METHOD = "getGpuImages";

    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
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
     * @ManyToOne(targetEntity="Manufacturer", inversedBy="videoCards")
     */
	private $manufacturer;

    /**
     * @var Chipset
     * @ManyToOne(targetEntity="Chipset", inversedBy="videoCards")
     */
	private $chipset;

    /**
     * @var float
     * @Column(type="float", name="memory")
	 */
	private $memory;

    /**
     * @var MemoryType
     * @ManyToOne(targetEntity="MemoryType", inversedBy="videoCards")
     * @JoinColumn(name="memory_type_id")
     */
	private $memoryType;

    /**
     * @var float
     * @Column(type="float", name="core_clock")
	 */
	private $coreClock;

    /**
     * @var float
     * @Column(type="float", name="boost_clock")
	 */
	private $boostClock;

    /**
     * @var float
     * @Column(type="float", name="effective_memory_clock")
	 */
	private $effectiveMemoryClock;

    /**
     * @var GpuInterface
     * @ManyToOne(targetEntity="GpuInterface", inversedBy="videoCards")
     * @JoinColumn(name="gpu_interface_id")
     */
	private $gpuInterface;

    /**
     * @ManyToMany(targetEntity="SliCrossfireType", inversedBy="sliCrossfireTypes")
     * @JoinTable(name="sli_crossfire_video_cards",
     *      joinColumns={@JoinColumn(name="video_card_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="sli_crossfire_type_id", referencedColumnName="id")}
     *      )
     */
	private $sliCrossfireTypes;

    /**
     * @ManyToMany(targetEntity="FrameSyncType", inversedBy="videoCards")
     * @JoinTable(name="frame_sync_video_cards",
     *      joinColumns={@JoinColumn(name="video_card_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="frame_sync_type_id", referencedColumnName="id")}
     *      )
     */
	private $frameSyncTypes;

    /**
     * @var float
     * @Column(type="float", name="length")
	 */
	private $length;

    /**
     * @var float
     * @Column(type="float", name="tdp")
	 */
	private $tdp;

    /**
     * @var float
     * @Column(type="float", name="expansion_slot_width")
	 */
	private $expansionSlotWidth;

    /**
     * @ManyToMany(targetEntity="ExternalPowerType", inversedBy="videoCards")
     * @JoinTable(name="gpus_external_power_types",
     *      joinColumns={@JoinColumn(name="video_card_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="external_power_type_id", referencedColumnName="id")}
     *      )
     */
    private $externalPowerTypes;

    /**
     * @ManyToMany(targetEntity="GpuCoolingType", inversedBy="videoCards")
     * @JoinTable(name="gpus_cooling_types",
     *      joinColumns={@JoinColumn(name="video_card_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="gpu_cooling_type_id", referencedColumnName="id")}
     *      )
     */
    private $gpuCoolingTypes;

    /**
     * @ManyToMany(targetEntity="GpuPort", inversedBy="videoCards")
     * @JoinTable(name="gpus_ports",
     *      joinColumns={@JoinColumn(name="video_card_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="gpu_port_id", referencedColumnName="id")}
     *      )
     */
    private $gpuPorts;

    /**
     * @ManyToMany(targetEntity="Color", inversedBy="videoCards")
     * @JoinTable(name="gpus_colors",
     *      joinColumns={@JoinColumn(name="video_card_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="color_id", referencedColumnName="id")}
     *      )
     */
    private $colors;

    /**
     * @OneToMany(targetEntity="GpuPartNumber", mappedBy="videoCard")
     */
    private $partNumbers;

    /**
     * @OneToMany(targetEntity="GpuPrice", mappedBy="gpu")
     */
    private $gpuPrices;

    /**
     * @OneToMany(targetEntity="GpuImage", mappedBy="gpu")
     */
    private $gpuImages;

    public function __construct()
    {
        $this->externalPowerTypes = new ArrayCollection();
        $this->gpuCoolingTypes = new ArrayCollection();
        $this->gpuPorts = new ArrayCollection();
        $this->colors = new ArrayCollection();
        $this->partNumbers = new ArrayCollection();
        $this->sliCrossfireTypes = new ArrayCollection();
        $this->frameSyncTypes = new ArrayCollection();
        $this->gpuPrices = new ArrayCollection();
        $this->gpuImages = new ArrayCollection();
    }

    /**
     * @return int
     */
	public function getId(): int
	{
		return $this->id;
	}

    /**
     * @param int
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
     * @param string
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
     * @param string
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
     * @param Manufacturer
     */
	public function setManufacturer(Manufacturer $manufacturer): void
	{
		$this->manufacturer = $manufacturer;
	}

    /**
     * @return null|Chipset
     */
	public function getChipset(): ?Chipset
	{
		return $this->chipset;
	}

    /**
     * @param null|Chipset
     */
	public function setChipset(?Chipset $chipset): void
	{
		$this->chipset = $chipset;
	}

    /**
     * @return null|float
     */
	public function getMemory(): ?float
	{
		return $this->memory;
	}

    /**
     * @param null|float
     */
	public function setMemory(?float $memory): void
	{
		$this->memory = $memory;
	}

    /**
     * @return null|MemoryType
     */
	public function getMemoryType(): ?MemoryType
	{
		return $this->memoryType;
	}

    /**
     * @param null|MemoryType
     */
	public function setMemoryType(?MemoryType $memoryType): void
	{
		$this->memoryType = $memoryType;
	}

    /**
     * @return null|float
     */
	public function getCoreClock(): ?float
	{
		return $this->coreClock;
	}

    /**
     * @param null|float
     */
	public function setCoreClock(?float $coreClock): void
	{
		$this->coreClock = $coreClock;
	}

    /**
     * @return null|float
     */
	public function getBoostClock(): ?float
	{
		return $this->boostClock;
	}

    /**
     * @param null|float
     */
	public function setBoostClock(?float $boostClock): void
	{
		$this->boostClock = $boostClock;
	}

    /**
     * @return null|float
     */
	public function getEffectiveMemoryClock(): ?float
	{
		return $this->effectiveMemoryClock;
	}

    /**
     * @param null|float
     */
	public function setEffectiveMemoryClock(?float $effectiveMemoryClock): void
	{
		$this->effectiveMemoryClock = $effectiveMemoryClock;
	}

    /**
     * @return null|GpuInterface
     */
	public function getGpuInterface(): ?GpuInterface
	{
		return $this->gpuInterface;
	}

    /**
     * @param null|GpuInterface
     */
	public function setGpuInterface(?GpuInterface $gpuInterface): void
	{
		$this->gpuInterface = $gpuInterface;
	}

	public function getSliCrossfireTypes()
	{
		return $this->sliCrossfireTypes;
	}

	public function addSliCrossfireType(SliCrossfireType $sliCrossfireType): void
	{
        if (!$this->sliCrossfireTypes->contains($sliCrossfireType)) {
            $this->sliCrossfireTypes[] = $sliCrossfireType;
            $sliCrossfireType->addVideoCard($this);
        }
	}

	public function getFrameSyncType()
	{
		return $this->frameSyncTypes;
	}

	public function addFrameSyncType(FrameSyncType $frameSyncType): void
	{
        if (!$this->frameSyncTypes->contains($frameSyncType)) {
            $this->frameSyncTypes[] = $frameSyncType;
            $frameSyncType->addVideoCard($this);
        }
	}

    /**
     * @return null|float
     */
	public function getLength(): ?float
	{
		return $this->length;
	}

    /**
     * @param null|float
     */
	public function setLength(?float $length): void
	{
		$this->length = $length;
	}

    /**
     * @return null|float
     */
	public function getTdp(): ?float
	{
		return $this->tdp;
	}

    /**
     * @param null|float
     */
	public function setTdp(?float $tdp): void
	{
		$this->tdp = $tdp;
	}

    /**
     * @return null|float
     */
	public function getExpansionSlotWidth(): ?float
	{
		return $this->expansionSlotWidth;
	}

    /**
     * @param null|float
     */
	public function setExpansionSlotWidth(?float $expansionSlotWidth): void
	{
		$this->expansionSlotWidth = $expansionSlotWidth;
	}

    /**
     * @return mixed
     */
    public function getExternalPowerTypes()
    {
        return $this->externalPowerTypes;
    }

    /**
     * @param ExternalPowerType $externalPowerType
     */
    public function addExternalPowerType(ExternalPowerType $externalPowerType): void
    {
        if (!$this->externalPowerTypes->contains($externalPowerType)) {
            $this->externalPowerTypes[] = $externalPowerType;
            $externalPowerType->addVideoCard($this);
        }
    }

    /**
     * @return mixed
     */
    public function getGpuCoolingTypes()
    {
        return $this->gpuCoolingTypes;
    }

    /**
     * @param GpuCoolingType $gpuCoolingType
     */
    public function addGpuCoolingType(GpuCoolingType $gpuCoolingType): void
    {
        if (!$this->gpuCoolingTypes->contains($gpuCoolingType)) {
            $this->gpuCoolingTypes[] = $gpuCoolingType;
            $gpuCoolingType->addVideoCard($this);
        }
    }

    /**
     * @return mixed
     */
    public function getGpuPorts()
    {
        return $this->gpuPorts;
    }

    /**
     * @param GpuPort $gpuPort
     */
    public function addGpuPort(GpuPort $gpuPort): void
    {
        if (!$this->gpuPorts->contains($gpuPort)) {
            $this->gpuPorts[] = $gpuPort;
            $gpuPort->addVideoCard($this);
        }
    }

    /**
     * @return mixed
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * @param Color $color
     */
    public function addColor(Color $color): void
    {
        if (!$this->colors->contains($color)) {
            $this->colors[] = $color;
            $color->addVideoCard($this);
        }
    }

    /**
     * @return mixed
     */
    public function getPartNumbers()
    {
        return $this->partNumbers;
    }

    /**
     * @param GpuPartNumber $partNumber
     */
    public function addPartNumber(GpuPartNumber $partNumber): void
    {
        if (!$this->partNumbers->contains($partNumber)) {
            $this->partNumbers[] = $partNumber;
            $partNumber->setVideoCard($this);
        }
    }

    /**
     * @return mixed
     */
    public function getGpuPrices()
    {
        return $this->gpuPrices;
    }

    /**
     * @param GpuPrice $gpuPrice
     */
    public function addGpuPrice(GpuPrice $gpuPrice): void
    {
        if (!$this->gpuPrices->contains($gpuPrice)) {
            $this->gpuPrices[] = $gpuPrice;
            $gpuPrice->setGpu($this);
        }
    }

    /**
     * @return mixed
     */
    public function getGpuImages()
    {
        return $this->gpuImages;
    }

    /**
     * @param GpuImage $gpuImage
     */
    public function addGpuImage(GpuImage $gpuImage): void
    {
        if (!$this->gpuImages->contains($gpuImage)) {
            $this->gpuImages[] = $gpuImage;
            $gpuImage->setGpu($this);
        }
    }
}
