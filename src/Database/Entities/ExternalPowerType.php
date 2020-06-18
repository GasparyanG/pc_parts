<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="external_power_types")
 */
class ExternalPowerType 
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
     * @var string
     * @Column(type="string", name="type")
	 */
	private $type;

    /**
     * @var int
     * @Column(type="integer", name="pin_amount")
	 */
	private $pinAmount;

    /**
     * @ManyToMany(targetEntity="VideoCard", mappedBy="externalPowerTypes")
     * @JoinTable(name="gpus_external_power_types",
     *      joinColumns={@JoinColumn(name="external_power_type_id", referencedColumnName="id")},
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
	public function getPinAmount(): int
	{
		return $this->pinAmount;
	}

    /**
     * @param int
     */
	public function setPinAmount(int $pinAmount): void
	{
		$this->pinAmount = $pinAmount;
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
            $videoCard->addExternalPowerType($this);
        }
    }
}
