<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="sli_crossfire_types")
 */
class SliCrossfireType 
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
     * @ManyToMany(targetEntity="Motherboard", mappedBy="sliCrossfireTypes")
     * @JoinTable(name="sli_crossfire_motherboards",
     *      joinColumns={@JoinColumn(name="sli_crossfire_type_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="motherboard_id", referencedColumnName="id")}
     *      )
     */
	private $motherboards;

    /**
     * @OneToMany(targetEntity="VideoCard", mappedBy="sliCrossfireType")
     */
    private $videoCards;


    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
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

    public function addMotherboard(Motherboard $motherboard): void
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->addSliCrossfireType($this);
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
            $videoCard->setSliCrossfireType($this);
        }
    }
}
