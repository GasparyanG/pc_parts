<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

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

    /**
     * @var WirelessNetworkingType
     * @ManyToOne(targetEntity="WirelessNetworkingType", inversedBy="moterboards")
     * @JoinColumn(name="wireless_networking_type_id")
     */
	private $wirelessNetworkingType;

    /**
     * @OneToMany(targetEntity="MoboMemorySpeedType", mappedBy="motherboard")
     */
    private $moboMemorySpeedTypes;

    /**
     * @ManyToMany(targetEntity="SliCrossfireType", mappedBy="motherboards")
     * @JoinTable(name="sli_crossfire_motherboards",
     *      joinColumns={@JoinColumn(name="motherboard_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="sli_crossfire_type_id", referencedColumnName="id")}
     *      )
     */
    private $sliCrossfireTypes;

    /**
     * @ManyToMany(targetEntity="Usb", mappedBy="motherboards")
     * @JoinTable(name="motherboards_usbs",
     *      joinColumns={@JoinColumn(name="motherboard_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="usb_id", referencedColumnName="id")}
     *      )
     */
    private $usbs;

    /**
     * @OneToMany(targetEntity="OnboardEthernetType", mappedBy="motherboard")
     */
    private $onboardEthernetTypes;

    /**
     * @OneToMany(targetEntity="Pcie", mappedBy="motherboard")
     */
    private $pcies;

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
     * @ManyToMany(targetEntity="Color", mappedBy="motherboards")
     */
    private $colors;

    /**
     * @OneToMany(targetEntity="MotherboardSataType", mappedBy="motherboard")
     */
    private $motherboardSataTypes;

    /**
     * @OneToMany(targetEntity="MotherboardPartNumber", mappedBy="motherboard")
     */
    private $motherboardPartNumbers;

    public function __construct()
    {
        $this->moboMemorySpeedTypes = new ArrayCollection();
        $this->sliCrossfireTypes = new ArrayCollection();
        $this->onboardEthernetTypes = new ArrayCollection();
        $this->pcies = new ArrayCollection();
        $this->colors = new ArrayCollection();
        $this->usbs = new ArrayCollection();
        $this->motherboardSataTypes = new ArrayCollection();
        $this->motherboardPartNumbers = new ArrayCollection();
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

    /**
     * @return null|WirelessNetworkingType
     */
	public function getWirelessNetworkingType(): ?WirelessNetworkingType
	{
		return $this->wirelessNetworkingType;
	}

    /**
     * @param null|WirelessNetworkingType
     */
	public function setWirelessNetworkingType(?WirelessNetworkingType $wirelessNetworkingType): void
	{
		$this->wirelessNetworkingType = $wirelessNetworkingType;
	}

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

    /**
     * @return mixed
     */
    public function getMoboMemorySpeedTypes()
    {
        return $this->moboMemorySpeedTypes;
    }

    /**
     * @param MoboMemorySpeedType $moboMemorySpeedType
     */
    public function addMoboMemorySpeedType(MoboMemorySpeedType $moboMemorySpeedType): void
    {
        if (!$this->moboMemorySpeedTypes->contains($moboMemorySpeedType)) {
            $this->moboMemorySpeedTypes[] = $moboMemorySpeedType;
            $moboMemorySpeedType->setMotherboard($this);
        }
    }

    /**
     * @return mixed
     */
    public function getSliCrossfireTypes()
    {
        return $this->sliCrossfireTypes;
    }

    public function addSliCrossfireType(SliCrossfireType $sliCrossfireType): void
    {
        if (!$this->sliCrossfireTypes->contains($sliCrossfireType)) {
            $this->sliCrossfireTypes[] = $sliCrossfireType;
            $sliCrossfireType->addMotherboard($this);
        }
    }

    /**
     * @return mixed
     */
    public function getOnboardEthernetTypes()
    {
        return $this->onboardEthernetTypes;
    }

    public function addOnboardEthernetType(OnboardEthernetType $onboardEthernetType): void
    {
        if (!$this->onboardEthernetTypes->contains($onboardEthernetType)) {
            $this->onboardEthernetTypes[] = $onboardEthernetType;
            $onboardEthernetType->setMotherboard($this);
        }
    }

    /**
     * @return mixed
     */
    public function getPcies()
    {
        return $this->pcies;
    }

    public function addPcie(Pcie $pcie): void
    {
        if (!$this->pcies->contains($pcie)) {
            $this->pcies[] = $pcie;
            $pcie->setMotherboard($this);
        }
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
            $color->addMotherboard($this);
        }
    }

    /**
     * @return mixed
     */
    public function getUsbs()
    {
        return $this->usbs;
    }

    public function addUsb(Usb $usb): void
    {
        if(!$this->usbs->contains($usb)) {
            $this->usbs[] = $usb;
            $usb->addMotherboard($this);
        }
    }

    /**
     * @return mixed
     */
    public function getMotherboardSataTypes()
    {
        return $this->motherboardSataTypes;
    }

    public function addMotherboardSataType(MotherboardSataType $motherboardSataType): void
    {
        if (!$this->motherboardSataTypes->contains($motherboardSataType)) {
            $this->motherboardSataTypes[] = $motherboardSataType;
            $motherboardSataType->setMotherboard($this);
        }
    }

    /**
     * @return mixed
     */
    public function getMotherboardPartNumbers()
    {
        return $this->motherboardPartNumbers;
    }

    public function addMotherboardPartNumber(MotherboardPartNumber $motherboardPartNumber): void
    {
        if (!$this->motherboardPartNumbers->contains($motherboardPartNumber)) {
            $this->motherboardPartNumbers[] = $motherboardPartNumber;
            $motherboardPartNumber->setMotherboard($this);
        }
    }
}
