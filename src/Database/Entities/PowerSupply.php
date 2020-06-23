<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

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

    /**
     * @var null|PsuFormFactor
     * @ManyToOne(targetEntity="PsuFormFactor", inversedBy="powerSupplies")
     * @JoinColumn(name="psu_form_factor_id")
     */
	private $psuFormFactor;

    /**
     * @var EfficiencyRating
     * @ManyToOne(targetEntity="EfficiencyRating", inversedBy="powerSupplies")
     * @JoinColumn(name="efficiency_rating_id")
     */
	private $efficiencyRating;

	/**
     * @OneToMany(targetEntity="PsuConnector", mappedBy="powerSupply")
	 */
	private $psuConnectors;

    /**
     * @OneToMany(targetEntity="PsuPartNumber", mappedBy="powerSupply")
     */
    private $psuPartNumbers;

    /**
     * @ManyToMany(targetEntity="Color", inversedBy="powerSupplies")
     * @JoinTable(name="psus_colors",
     *      joinColumns={@JoinColumn(name="power_supply_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="color_id", referencedColumnName="id")}
     *      )
     */
    private $colors;

    /**
     * @var float
     * @Column(type="float", name="length")
	 */
	private $length;

    /**
     * @var bool|null
     * @Column(type="boolean", name="fanless")
	 */
	private $fanless;

    /**
     * @var string
     * @Column(type="string", name="modular")
	 */
	private $modular;

	/**
     * @OneToMany(targetEntity="PsuPrice", mappedBy="psu")
	 */
	private $psuPrices;

    public function __construct()
    {
        $this->psuConnectors = new ArrayCollection();
        $this->psuPartNumbers = new ArrayCollection();
        $this->colors = new ArrayCollection();
        $this->psuPrices = new ArrayCollection();
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
     * @return null|PsuFormFactor
     */
	public function getPsuFormFactor(): ?PsuFormFactor
	{
		return $this->psuFormFactor;
	}

    /**
     * @param null|PsuFormFactor
     */
	public function setPsuFormFactor(?PsuFormFactor $psuFormFactorId): void
	{
		$this->psuFormFactor = $psuFormFactorId;
	}

    /**
     * @return null|EfficiencyRating
     */
	public function getEfficiencyRating(): ?EfficiencyRating
	{
		return $this->efficiencyRating;
	}

    /**
     * @param null|EfficiencyRating
     */
	public function setEfficiencyRating(?EfficiencyRating $efficiencyRating): void
	{
		$this->efficiencyRating = $efficiencyRating;
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
     * @return null|bool
     */
	public function getFanless(): ?bool
	{
		return $this->fanless;
	}

    /**
     * @param null|bool
     */
	public function setFanless(?bool $fanless): void
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

    /**
     * @return mixed
     */
    public function getPsuConnectors()
    {
        return $this->psuConnectors;
    }

    /**
     * @param PsuConnector
     */
    public function addPsuConnector(PsuConnector $psuConnector): void
    {
        if (!$this->psuConnectors->contains($psuConnector)) {
            $this->psuConnectors[] = $psuConnector;
            $psuConnector->setPowerSupply($this);
        }
    }

    /**
     * @return mixed
     */
    public function getPsuPartNumbers()
    {
        return $this->psuPartNumbers;
    }

    /**
     * @param PsuPartNumber
     */
    public function addPsuPartNumber(PsuPartNumber $psuPartNumber): void
    {
        if (!$this->psuPartNumbers->contains($psuPartNumber)) {
            $this->psuPartNumbers[] = $psuPartNumber;
            $psuPartNumber->setPowerSupply($this);
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
     * @param Color
     */
    public function addColor(Color $color): void
    {
        if (!$this->colors->contains($color)) {
            $this->colors[] = $color;
            $color->addPowerSupply($this);
        }
    }

    /**
     * @return mixed
     */
    public function getPsuPrices()
    {
        return $this->psuPrices;
    }

    /**
     * @param PsuPrice $psuPrice
     */
    public function addPsuPrice(PsuPrice $psuPrice): void
    {
        if (!$this->psuPrices->contains($psuPrice)) {
            $this->psuPrices[] = $psuPrice;
            $psuPrice->setPsu($this);
        }
    }
}
