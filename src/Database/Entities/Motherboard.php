<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="motherboards")
 */
class Motherboard 
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
     * @ManyToOne(targetEntity="Manufacturer", inversedBy="motherboards")
     */
	private $manufacturer;

    /**
     * @var CpuSocket
     * @ManyToOne(targetEntity="CpuSocket", inversedBy="motherboards")
     * @JoinColumn(name="cpu_socket_id")
     */
	private $cpuSocket;

    /**
     * @var MoboFormFactor
     * @ManyToOne(targetEntity="MoboFormFactor", inversedBy="motherboards")
     * @JoinColumn(name="mobo_form_factor_id")
     */
	private $moboFormFactor;

    /**
     * @var Chipset
     * @ManyToOne(targetEntity="Chipset", inversedBy="motherboards")
     */
	private $chipset;

    /**
     * @var float
     * @Column(type="float", name="max_memory")
	 */
	private $maxMemory;

    /**
     * @var MemoryType
     * @ManyToOne(targetEntity="MemoryType", inversedBy="motherboards")
     * @JoinColumn(name="memory_type_id")
     */
	private $memoryType;

    /**
     * @var int
     * @Column(type="integer", name="memory_slots")
	 */
	private $memorySlots;

    /**
     * @var int
     * @Column(type="integer", name="onboard_video")
	 */
	private $onboardVideo;

    /**
     * @var int
     * @Column(type="integer", name="supports_ecc")
	 */
	private $supportsEcc;

//    /**
//     * @ManyToOne(targetEntity="", inversedBy="")
//     */
//	private $wirelessNetworkingTypeId;

    /**
     * @var int
     * @Column(type="integer", name="raid_support")
	 */
	private $raidSupport;

    /**
     * @var int
     * @Column(type="integer", name="pci_slots")
	 */
	private $pciSlots;

    /**
     * @var int
     * @Column(type="integer", name="msata_slots")
	 */
	private $msataSlots;

    /**
     * @var int
     * @Column(type="integer", name="stata_express")
	 */
	private $stataExpress;


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
     * @return CpuSocket
     */
	public function getCpuSocket(): CpuSocket
	{
		return $this->cpuSocket;
	}

    /**
     * @param CpuSocket
     */
	public function setCpuSocket(CpuSocket $cpuSocket): void
	{
		$this->cpuSocket = $cpuSocket;
	}

    /**
     * @return null|MoboFormFactor
     */
	public function getMoboFormFactor(): ?MoboFormFactor
	{
		return $this->moboFormFactor;
	}

    /**
     * @param null|MoboFormFactor
     */
	public function setMoboFormFactor(?MoboFormFactor $moboFormFactor): void
	{
		$this->moboFormFactor = $moboFormFactor;
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
	public function getMaxMemory(): ?float
	{
		return $this->maxMemory;
	}

    /**
     * @param null|float
     */
	public function setMaxMemory(?float $maxMemory): void
	{
		$this->maxMemory = $maxMemory;
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
     * @return null|int
     */
	public function getMemorySlots(): ?int
	{
		return $this->memorySlots;
	}

    /**
     * @param null|int
     */
	public function setMemorySlots(?int $memorySlots): void
	{
		$this->memorySlots = $memorySlots;
	}

    /**
     * @return null|int
     */
	public function getOnboardVideo(): ?int
	{
		return $this->onboardVideo;
	}

    /**
     * @param null|int
     */
	public function setOnboardVideo(?int $onboardVideo): void
	{
		$this->onboardVideo = $onboardVideo;
	}

    /**
     * @return null|int
     */
	public function getSupportsEcc(): ?int
	{
		return $this->supportsEcc;
	}

    /**
     * @param null|int
     */
	public function setSupportsEcc(?int $supportsEcc): void
	{
		$this->supportsEcc = $supportsEcc;
	}

//    /**
//     * @return null|int
//     */
//	public function getWirelessNetworkingTypeId(): ?int
//	{
//		return $this->wirelessNetworkingTypeId;
//	}
//
//    /**
//     * @param null|int
//     */
//	public function setWirelessNetworkingTypeId(?int $wirelessNetworkingTypeId): void
//	{
//		$this->wirelessNetworkingTypeId = $wirelessNetworkingTypeId;
//	}

    /**
     * @return null|int
     */
	public function getRaidSupport(): ?int
	{
		return $this->raidSupport;
	}

    /**
     * @param null|int
     */
	public function setRaidSupport(?int $raidSupport): void
	{
		$this->raidSupport = $raidSupport;
	}

    /**
     * @return null|int
     */
	public function getPciSlots(): ?int
	{
		return $this->pciSlots;
	}

    /**
     * @param null|int
     */
	public function setPciSlots(?int $pciSlots): void
	{
		$this->pciSlots = $pciSlots;
	}

    /**
     * @return null|int
     */
	public function getMsataSlots(): ?int
	{
		return $this->msataSlots;
	}

    /**
     * @param null|int
     */
	public function setMsataSlots(?int $msataSlots): void
	{
		$this->msataSlots = $msataSlots;
	}

    /**
     * @return null|int
     */
	public function getStataExpress(): ?int
	{
		return $this->stataExpress;
	}

    /**
     * @param null|int
     */
	public function setStataExpress(?int $stataExpress): void
	{
		$this->stataExpress = $stataExpress;
	}
}
