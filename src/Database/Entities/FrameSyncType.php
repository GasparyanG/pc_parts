<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="frame_sync_types")
 */
class FrameSyncType 
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
     * @ManyToMany(targetEntity="VideoCard", mappedBy="frameSyncTypes")
     * @JoinTable(name="frame_sync_video_cards",
     *      joinColumns={@JoinColumn(name="frame_sync_type_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="video_card_id", referencedColumnName="id")}
     *      )
     */
    private $videoCards;

    public function __construct()
    {
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
            $videoCard->addFrameSyncType($this);
        }
    }
}
