<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="onboard_ethernet_types")
 */
class OnboardEthernetType 
{
    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
	 * @GeneratedValue
	 */
	private $id;

    /**
     * @var int
     * @Column(type="integer", name="amount")
	 */
	private $amount;

    /**
     * @var int
     * @Column(type="integer", name="speed")
	 */
	private $speed;

    /**
     * @var Motherboard
     * @ManyToOne(targetEntity="Motherboard", inversedBy="onboardEthernetTypes")
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
     * @return int
     */
	public function getSpeed(): int
	{
		return $this->speed;
	}

    /**
     * @param int
     */
	public function setSpeed(int $speed): void
	{
		$this->speed = $speed;
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
