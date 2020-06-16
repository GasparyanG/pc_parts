<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="pcies")
 */
class Pcie 
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
     * @Column(type="integer", name="slots_count")
	 */
	private $slotsCount;

    /**
     * @var int
     * @Column(type="integer", name="amount")
	 */
	private $amount;

    /**
     * @var Motherboard
     * @ManyToOne(targetEntity="Motherboard", inversedBy="pcies")
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
     * @return int
     */
	public function getSlotsCount(): int
	{
		return $this->slotsCount;
	}

    /**
     * @param int
     */
	public function setSlotsCount(int $slotsCount): void
	{
		$this->slotsCount = $slotsCount;
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
	public function getMotherboardId(): int
	{
		return $this->motherboardId;
	}

    /**
     * @param int
     */
	public function setMotherboardId(int $motherboardId): void
	{
		$this->motherboardId = $motherboardId;
	}

    /**
     * @return Motherboard
     */
    public function getMotherboard(): Motherboard
    {
        return $this->motherboard;
    }

    /**
     * @param Motherboard $motherboard
     */
    public function setMotherboard(Motherboard $motherboard): void
    {
        $this->motherboard = $motherboard;
    }
}
