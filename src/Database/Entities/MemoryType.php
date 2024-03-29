<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="memory_types")
 */
class MemoryType 
{
    const TYPE = "type";
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
     * @OneToMany(targetEntity="Motherboard", mappedBy="memoryType")
     */
    private $motherboards;

    /**
     * @OneToMany(targetEntity="MoboMemorySpeedType", mappedBy="memoryType")
     */
    private $moboMemorySpeedTypes;

    /**
     * @OneToMany(targetEntity="VideoCard", mappedBy="memoryType")
     */
    private $videoCards;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->moboMemorySpeedTypes = new ArrayCollection();
        $this->videoCards = new ArrayCollection();
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
    public function getMotherboards()
    {
        return $this->motherboards;
    }

    /**
     * @param Motherboard
     */
    public function addMotherboard(Motherboard $motherboard): void
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->setMemoryType($this);
        }
    }

    /**
     * @return mixed
     */
    public function getMoboMemorySpeedTypes()
    {
        return $this->moboMemorySpeedTypes;
    }

    /**
     * @param MoboMemorySpeedType $moboMemorySpeedType
     */
    public function addMoboMemorySpeedType(MoboMemorySpeedType $moboMemorySpeedType): void
    {
        if (!$this->moboMemorySpeedTypes->contains($moboMemorySpeedType)) {
            $this->moboMemorySpeedTypes[] = $moboMemorySpeedType;
            $moboMemorySpeedType->setMemoryType($this);
        }
    }

    /**
     * @return mixed
     */
    public function getVideoCards()
    {
        return $this->videoCards;
    }

    /**
     * @param VideoCard
     */
    public function addVideoCard(VideoCard $videoCard): void
    {
        if (!$this->videoCards->contains($videoCard)) {
            $this->videoCards[] = $videoCard;
            $videoCard->setMemoryType($this);
        }
    }
}
