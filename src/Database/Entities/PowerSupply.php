<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="power_supplies")
 */
class PowerSupply
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
     * @Column(type="float", name="wattage")
	 */
	private $wattage;

    /**
     * @var Manufacturer
     * @ManyToOne(targetEntity="Manufacturer", inversedBy="powerSupplies")
     */
	private $manufacturer;

//    /**
//     * @ManyToOne(targetEntity="", inversedBy="")
//     */
//	private $psuFormFactor;
//
//    /**
//     * @ManyToOne(targetEntity="", inversedBy="")
//     */
//	private $efficiencyRatingId;

    /**
     * @var float
     * @Column(type="float", name="length")
	 */
	private $length;

    /**
     * @var int
     * @Column(type="integer", name="fanless")
	 */
	private $fanless;

    /**
     * @var string
     * @Column(type="string", name="modular")
	 */
	private $modular;


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
     * @return null|float
     */
	public function getWattage(): ?float
	{
		return $this->wattage;
	}

    /**
     * @param null|float
     */
	public function setWattage(?float $wattage): void
	{
		$this->wattage = $wattage;
	}

    /**
     * @return int
     */
	public function getManufacturer(): Manufacturer
	{
		return $this->manufacturer;
	}

    /**
     * @param int
     */
	public function setManufacturer(Manufacturer $manufacturer): void
	{
		$this->manufacturer = $manufacturer;
	}

//    /**
//     * @return null|int
//     */
//	public function getPsuFormFactorId(): ?int
//	{
//		return $this->psuFormFactorId;
//	}
//
//    /**
//     * @param null|int
//     */
//	public function setPsuFormFactorId(?int $psuFormFactorId): void
//	{
//		$this->psuFormFactorId = $psuFormFactorId;
//	}
//
//    /**
//     * @return null|int
//     */
//	public function getEfficiencyRatingId(): ?int
//	{
//		return $this->efficiencyRatingId;
//	}
//
//    /**
//     * @param null|int
//     */
//	public function setEfficiencyRatingId(?int $efficiencyRatingId): void
//	{
//		$this->efficiencyRatingId = $efficiencyRatingId;
//	}

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
     * @return null|int
     */
	public function getFanless(): ?int
	{
		return $this->fanless;
	}

    /**
     * @param null|int
     */
	public function setFanless(?int $fanless): void
	{
		$this->fanless = $fanless;
	}

    /**
     * @return null|string
     */
	public function getModular(): ?string
	{
		return $this->modular;
	}

    /**
     * @param null|string
     */
	public function setModular(?string $modular): void
	{
		$this->modular = $modular;
	}
}
