<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="video_cards")
 */
class VideoCard 
{
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

//    /**
//     * @ManyToOne(targetEntity="", inversedBy="")
//     */
//	private $gpuInterfaceId;
//
    /**
     * @var SliCrossfireType
     * @ManyToOne(targetEntity="SliCrossfireType", inversedBy="videoCards")
     * @JoinColumn(name="sli_crossfire_type_id")
     */
	private $sliCrossfireType;

    /**
     * @var FrameSyncType
     * @ManyToOne(targetEntity="FrameSyncType", inversedBy="videoCards")
     * @JoinColumn(name="frame_sync_type_id")
     */
	private $frameSyncType;

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
//     * @return null|int
//     */
//	public function getGpuInterfaceId(): ?int
//	{
//		return $this->gpuInterfaceId;
//	}
//
//    /**
//     * @param null|int
//     */
//	public function setGpuInterfaceId(?int $gpuInterfaceId): void
//	{
//		$this->gpuInterfaceId = $gpuInterfaceId;
//	}
//
    /**
     * @return null|SliCrossfireType
     */
	public function getSliCrossfireType(): ?SliCrossfireType
	{
		return $this->sliCrossfireType;
	}

    /**
     * @param null|SliCrossfireType
     */
	public function setSliCrossfireType(?SliCrossfireType $sliCrossfireType): void
	{
		$this->sliCrossfireType = $sliCrossfireType;
	}

    /**
     * @return null|FrameSyncType
     */
	public function getFrameSyncType(): ?FrameSyncType
	{
		return $this->frameSyncType;
	}

    /**
     * @param null|FrameSyncType
     */
	public function setFrameSyncType(?FrameSyncType $frameSyncType): void
	{
		$this->frameSyncType = $frameSyncType;
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
}
