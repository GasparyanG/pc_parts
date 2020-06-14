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

    public function __construct()
    {
        $this->psuConnectors = new ArrayCollection();
    }

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
}
