<?php
namespace App\Database\Entities;

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
}
