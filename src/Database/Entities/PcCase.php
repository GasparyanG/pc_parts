<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="pc_cases")
 */
class PcCase 
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
     * @ManyToOne(targetEntity="Manufacturer", inversedBy="pcCases")
     */
	private $manufacturer;

    /**
     * @var CaseType
     * @ManyToOne(targetEntity="CaseType", inversedBy="pcCases")
     * @JoinColumn(name="case_type_id")
     */
	private $caseType;

    /**
     * @var float
     * @Column(type="float", name="power_supply")
	 */
	private $powerSupply;

    /**
     * @var SidePanelWindowType
     * @ManyToOne(targetEntity="SidePanelWindowType", inversedBy="pcCases")
     * @JoinColumn(name="side_panel_window_type_id")
     */
	private $sidePanelWindowType;

    /**
     * @var bool
     * @Column(type="boolean", name="power_supply_shroud")
	 */
	private $powerSupplyShroud;

    /**
     * @var CaseDimension
     * @ManyToOne(targetEntity="CaseDimension", inversedBy="pcCases")
     * @JoinColumn(name="case_dimension_id")
     */
	private $caseDimension;

    /**
     * @ManyToMany(targetEntity="Usb", inversedBy="pcCases")
     * @JoinTable(name="cases_usbs",
     *      joinColumns={@JoinColumn(name="case_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="usb_id", referencedColumnName="id")}
     *      )
     */
    private $usbs;

    /**
     * @ManyToMany(targetEntity="MoboFormFactor", inversedBy="pcCases")
     * @JoinTable(name="cases_form_factors",
     *      joinColumns={@JoinColumn(name="case_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="mobo_form_factor_id", referencedColumnName="id")}
     *      )
     */
    private $formFactors;

    /**
     * @ManyToMany(targetEntity="ExpansionSlot", inversedBy="pcCases")
     * @JoinTable(name="cases_expansion_slots",
     *      joinColumns={@JoinColumn(name="case_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="expansion_slot_id", referencedColumnName="id")}
     *      )
     */
    private $expansionSlots;

    /**
     * @ManyToMany(targetEntity="CaseBay", inversedBy="pcCases")
     * @JoinTable(name="cases_bays",
     *      joinColumns={@JoinColumn(name="case_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="bay_id", referencedColumnName="id")}
     *      )
     */
    private $bays;

    /**
     * @OneToMany(targetEntity="CaseGpuLengthType", mappedBy="case")
     */
    private $caseGpuLengthTypes;

    /**
     * @var float|null
     * @Column(type="float", name="volume")
     */
    private $volume;

    /**
     * @ManyToMany(targetEntity="Color", inversedBy="casses")
     * @JoinTable(name="cases_colors",
     *      joinColumns={@JoinColumn(name="case_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="color_id", referencedColumnName="id")}
     *      )
     */
    private $colors;

    /**
     * @OneToMany(targetEntity="CasePartNumber", mappedBy="case")
     */
    private $casePartNumbers;

    /**
     * @OneToMany(targetEntity="CasePrice", mappedBy="case")
     */
    private $casePrices;

    public function __construct()
    {
        $this->usbs = new ArrayCollection();
        $this->formFactors = new ArrayCollection();
        $this->expansionSlots = new ArrayCollection();
        $this->bays = new ArrayCollection();
        $this->caseGpuLengthTypes = new ArrayCollection();
        $this->colors = new ArrayCollection();
        $this->casePartNumbers = new ArrayCollection();
        $this->casePrices = new ArrayCollection();
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
     * @return null|CaseType
     */
	public function getCaseType(): ?CaseType
	{
		return $this->caseType;
	}

    /**
     * @param null|CaseType
     */
	public function setCaseType(?CaseType $caseType): void
	{
		$this->caseType = $caseType;
	}

    /**
     * @return null|float
     */
	public function getPowerSupply(): ?float
	{
		return $this->powerSupply;
	}

    /**
     * @param null|float
     */
	public function setPowerSupply(?float $powerSupply): void
	{
		$this->powerSupply = $powerSupply;
	}

    /**
     * @return null|SidePanelWindowType
     */
	public function getSidePanelWindowType(): ?SidePanelWindowType
	{
		return $this->sidePanelWindowType;
	}

    /**
     * @param null|SidePanelWindowType
     */
	public function setSidePanelWindowType(?SidePanelWindowType $sidePanelWindowType): void
	{
		$this->sidePanelWindowType = $sidePanelWindowType;
	}

    /**
     * @return null|bool
     */
	public function getPowerSupplyShroud(): ?bool
	{
		return $this->powerSupplyShroud;
	}

    /**
     * @param null|bool
     */
	public function setPowerSupplyShroud(?bool $powerSupplyShroud): void
	{
		$this->powerSupplyShroud = $powerSupplyShroud;
	}

    /**
     * @return null|CaseDimension
     */
	public function getCaseDimension(): ?CaseDimension
	{
		return $this->caseDimension;
	}

    /**
     * @param null|CaseDimension
     */
	public function setCaseDimension(?CaseDimension $caseDimension): void
	{
		$this->caseDimension = $caseDimension;
	}

    /**
     * @return mixed
     */
    public function getUsbs()
    {
        return $this->usbs;
    }

    /**
     * @param Usb $usb
     */
    public function addUsb(Usb $usb): void
    {
        if (!$this->usbs->contains($usb)) {
            $this->usbs[] = $usb;
            $usb->addCase($this);
        }
    }

    /**
     * @return mixed
     */
    public function getFormFactors()
    {
        return $this->formFactors;
    }

    /**
     * @param MoboFormFactor $formFactor
     */
    public function addFormFactor(MoboFormFactor $formFactor): void
    {
        if (!$this->formFactors->contains($formFactor)) {
            $this->formFactors[] = $formFactor;
            $formFactor->addCase($this);
        }
    }

    /**
     * @return mixed
     */
    public function getExpansionSlots()
    {
        return $this->expansionSlots;
    }

    /**
     * @param ExpansionSlot $expansionSlot
     */
    public function addExpansionSlot(ExpansionSlot $expansionSlot): void
    {
        if (!$this->expansionSlots->contains($expansionSlot)) {
            $this->expansionSlots[] = $expansionSlot;
            $expansionSlot->addCase($this);
        }
    }

    /**
     * @return mixed
     */
    public function getBays()
    {
        return $this->bays;
    }

    /**
     * @param CaseBay $bay
     */
    public function addBay(CaseBay $bay): void
    {
        if (!$this->bays->contains($bay)) {
            $this->bays[] = $bay;
            $bay->addCase($this);
        }
    }

    /**
     * @return mixed
     */
    public function getCaseGpuLengthTypes()
    {
        return $this->caseGpuLengthTypes;
    }

    /**
     * @param CaseGpuLengthType $caseGpuLengthType
     */
    public function addCaseGpuLengthTypes(CaseGpuLengthType $caseGpuLengthType): void
    {
        if (!$this->caseGpuLengthTypes->contains($caseGpuLengthType)) {
            $this->caseGpuLengthTypes[] = $caseGpuLengthType;
            $caseGpuLengthType->setCase($this);
        }
    }

    /**
     * @return float|null
     */
    public function getVolume(): ?float
    {
        return $this->volume;
    }

    /**
     * @param float|null $volume
     */
    public function setVolume(?float $volume): void
    {
        $this->volume = $volume;
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
            $color->addCase($this);
        }
    }

    /**
     * @return mixed
     */
    public function getCasePartNumbers()
    {
        return $this->casePartNumbers;
    }

    /**
     * @param CasePartNumber $casePartNumber
     */
    public function addCasePartNumber(CasePartNumber $casePartNumber): void
    {
        if (!$this->casePartNumbers->contains($casePartNumber)) {
            $this->casePartNumbers[] = $casePartNumber;
            $casePartNumber->setCase($this);
        }
    }

    /**
     * @return mixed
     */
    public function getCasePrices()
    {
        return $this->casePrices;
    }

    /**
     * @param CasePrice $casePrice
     */
    public function addCasePrice(CasePrice $casePrice): void
    {
        if (!$this->casePrices->contains($casePrice)) {
            $this->casePrices[] = $casePrice;
            $casePrice->setCase($this);
        }
    }
}
