<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="psu_part_numbers")
 */
class PsuPartNumber 
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
     * @Column(type="string", name="part_number")
	 */
	private $partNumber;

    /**
     * @var PowerSupply
     * @ManyToOne(targetEntity="PowerSupply", inversedBy="psuPartNumbers")
     * @JoinColumn(name="power_supply_id")
     */
	private $powerSupply;

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
	public function getPartNumber(): string
	{
		return $this->partNumber;
	}

    /**
     * @param string
     */
	public function setPartNumber(string $partNumber): void
	{
		$this->partNumber = $partNumber;
	}

    /**
     * @return PowerSupply
     */
	public function getPowerSupply(): PowerSupply
	{
		return $this->powerSupply;
	}

    /**
     * @param PowerSupply
     */
	public function setPowerSupply(PowerSupply $powerSupply): void
	{
		$this->powerSupply = $powerSupply;
	}
}
