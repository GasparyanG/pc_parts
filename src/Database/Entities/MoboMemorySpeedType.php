<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="mobo_memory_speed_types")
 */
class MoboMemorySpeedType 
{
    const SPEED = "speed";
    const MEMORY_TYPE = "memoryType";
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
     * @var MemoryType
     * @ManyToOne(targetEntity="MemoryType", inversedBy="moboMemorySpeedTypes")
     * @JoinColumn(name="memory_type_id")
     */
	private $memoryType;

    /**
     * @var Motherboard
     * @ManyToOne(targetEntity="Motherboard", inversedBy="moboMemorySpeedTypes")
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
     * @return float
     */
	public function getSpeed(): float
	{
		return $this->speed;
	}

    /**
     * @param float
     */
	public function setSpeed(float $speed): void
	{
		$this->speed = $speed;
	}

    /**
     * @return MemoryType
     */
	public function getMemoryType(): MemoryType
	{
		return $this->memoryType;
	}

    /**
     * @param MemoryType
     */
	public function setMemoryType(MemoryType $memoryType): void
	{
		$this->memoryType = $memoryType;
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
