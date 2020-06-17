<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="motherboard_sata_types")
 */
class MotherboardSataType 
{
    const SPEED = "speed";
    const AMOUNT = "amount";
    const MOTHERBOARD = "motherboard";

    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
	 * @GeneratedValue
	 */
	private $id;

    /**
     * @var float
     * @Column(type="float", name="speed")
	 */
	private $speed;

    /**
     * @var int
     * @Column(type="integer", name="amount")
	 */
	private $amount;

    /**
     * @var Motherboard
     * @ManyToOne(targetEntity="Motherboard", inversedBy="motherboardSataTypes")
     */
	private $motherboard;

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
     * @return null|float
     */
	public function getSpeed(): ?float
	{
		return $this->speed;
	}

    /**
     * @param null|float
     */
	public function setSpeed(?float $speed): void
	{
		$this->speed = $speed;
	}

    /**
     * @return null|int
     */
	public function getAmount(): ?int
	{
		return $this->amount;
	}

    /**
     * @param null|int
     */
	public function setAmount(?int $amount): void
	{
		$this->amount = $amount;
	}

    /**
     * @return Motherboard
     */
	public function getMotherboard(): Motherboard
	{
		return $this->motherboard;
	}

    /**
     * @param Motherboard
     */
	public function setMotherboard(Motherboard $motherboard): void
	{
		$this->motherboard = $motherboard;
	}
}
