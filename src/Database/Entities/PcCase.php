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

//    /**
//     * @ManyToOne(targetEntity="", inversedBy="")
//     */
//	private $caseTypeId;

    /**
     * @var float
     * @Column(type="float", name="power_supply")
	 */
	private $powerSupply;

//    /**
//     * @ManyToOne(targetEntity="", inversedBy="")
//     */
//	private $sidePanelWindowTypeId;

    /**
     * @var bool
     * @Column(type="boolean", name="power_supply_shroud")
	 */
	private $powerSupplyShroud;

//    /**
//     * @ManyToOne(targetEntity="", inversedBy="")
//     */
//	private $caseDimensionId;


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

//    /**
//     * @return null|int
//     */
//	public function getCaseTypeId(): ?int
//	{
//		return $this->caseTypeId;
//	}
//
//    /**
//     * @param null|int
//     */
//	public function setCaseTypeId(?int $caseTypeId): void
//	{
//		$this->caseTypeId = $caseTypeId;
//	}

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

//    /**
//     * @return null|int
//     */
//	public function getSidePanelWindowTypeId(): ?int
//	{
//		return $this->sidePanelWindowTypeId;
//	}
//
//    /**
//     * @param null|int
//     */
//	public function setSidePanelWindowTypeId(?int $sidePanelWindowTypeId): void
//	{
//		$this->sidePanelWindowTypeId = $sidePanelWindowTypeId;
//	}

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

//    /**
//     * @return null|int
//     */
//	public function getCaseDimensionId(): ?int
//	{
//		return $this->caseDimensionId;
//	}
//
//    /**
//     * @param null|int
//     */
//	public function setCaseDimensionId(?int $caseDimensionId): void
//	{
//		$this->caseDimensionId = $caseDimensionId;
//	}
}
