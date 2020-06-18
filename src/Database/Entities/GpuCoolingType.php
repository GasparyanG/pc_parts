<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="gpu_cooling_types")
 */
class GpuCoolingType 
{
    const TYPE = "type";
    const MEASURE = "measure";

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
     * @var float
     * @Column(type="float", name="measure")
	 */
	private $measure;

    /**
     * @ManyToMany(targetEntity="VideoCard", mappedBy="gpuCoolingTypes")
     * @JoinTable(name="gpus_cooling_types",
     *      joinColumns={@JoinColumn(name="gpu_cooling_type_id", referencedColumnName="id")},
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
     * @return float
     */
	public function getMeasure(): float
	{
		return $this->measure;
	}

    /**
     * @param float
     */
	public function setMeasure(float $measure): void
	{
		$this->measure = $measure;
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
            $videoCard->addGpuCoolingType($this);
        }
    }
}
