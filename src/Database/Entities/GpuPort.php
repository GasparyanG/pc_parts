<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="gpu_ports")
 */
class GpuPort 
{
    const TYPE = "type";
    const AMOUNT = "amount";

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
     * @var int
     * @Column(type="integer", name="amount")
	 */
	private $amount;

    /**
     * @ManyToMany(targetEntity="VideoCard", mappedBy="gpuPorts")
     * @JoinTable(name="gpus_ports",
     *      joinColumns={@JoinColumn(name="gpu_port_id", referencedColumnName="id")},
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
     * @return int
     */
	public function getAmount(): int
	{
		return $this->amount;
	}

    /**
     * @param int
     */
	public function setAmount(int $amount): void
	{
		$this->amount = $amount;
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
            $videoCard->addGpuPort($this);
        }
    }
}
