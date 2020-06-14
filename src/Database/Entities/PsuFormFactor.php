<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="psu_form_factors")
 */
class PsuFormFactor 
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
     * @Column(type="string", name="type")
	 */
	private $type;

	/**
     * @OneToMany(targetEntity="PowerSupply", mappedBy="psuFormFactor")
	 */
	private $powerSupplies;

	public function __construct()
    {
        $this->powerSupplies = new ArrayCollection();
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
	public function getType(): string
	{
		return $this->type;
	}

    /**
     * @param string
     */
	public function setType(string $type): void
	{
		$this->type = $type;
	}

    /**
     * @return mixed
     */
    public function getPowerSupplies()
    {
        return $this->powerSupplies;
    }

    /**
     * @param Storage
     */
    public function addPowerSupply(PowerSupply $powerSupply): void
    {
        if (!$this->powerSupplies->contains($powerSupply)) {
            $this->powerSupplies[] = $powerSupply;
            $powerSupply->setPsuFormFactor($this);
        }
    }
}
