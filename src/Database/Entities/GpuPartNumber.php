<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="gpu_part_numbers")
 */
class GpuPartNumber 
{
    const PART_NUMBER = "partNumber";
    const VIDEO_CARD = "videoCard";
    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
	 * @GeneratedValue
	 */
	private $id;

    /**
     * @var string
     * @Column(type="string", name="part_number")
	 */
	private $partNumber;

    /**
     * @var VideoCard
     * @ManyToOne(targetEntity="VideoCard", inversedBy="gpuPartNumbera")
     * @JoinColumn(name="video_card_id")
     */
	private $videoCard;

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
	public function getPartNumber(): string
	{
		return $this->partNumber;
	}

    /**
     * @param string
     */
	public function setPartNumber(string $partNumber): void
	{
		$this->partNumber = $partNumber;
	}

    /**
     * @return VideoCard
     */
	public function getVideoCard(): VideoCard
	{
		return $this->videoCard;
	}

    /**
     * @param VideoCard
     */
	public function setVideoCard(VideoCard $videoCard): void
	{
		$this->videoCard = $videoCard;
	}
}
