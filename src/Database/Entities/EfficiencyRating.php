<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="efficiency_ratings")
 */
class EfficiencyRating 
{
    const RATING = "rating";
    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
	 * @GeneratedValue
	 */
	private $id;

    /**
     * @var string
     * @Column(type="string", name="rating")
	 */
	private $rating;

    /**
     * @OneToMany(targetEntity="PowerSupply", mappedBy="efficiencyRating")
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
	public function getRating(): string
	{
		return $this->rating;
	}

    /**
     * @param string
     */
	public function setRating(string $rating): void
	{
		$this->rating = $rating;
	}

    /**
     * @return mixed
     */
    public function getPowerSupplies()
    {
        return $this->powerSupplies;
    }

    /**
     * @param PowerSupply
     */
    public function addPowerSupply(PowerSupply $powerSupply): void
    {
        if (!$this->powerSupplies->contains($powerSupply)) {
            $this->powerSupplies[] = $powerSupply;
            $powerSupply->setEfficiencyRating($this);
        }
    }
}
