<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="gpu_images")
 */
class GpuImage 
{
    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
	 * @GeneratedValue
	 */
	private $id;

    /**
     * @var string
     * @Column(type="string", name="file_name")
	 */
	private $fileName;

    /**
     * @var VideoCard
     * @ManyToOne(targetEntity="VideoCard", inversedBy="gpuImages")
     */
	private $gpu;


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
	public function getFileName(): string
	{
		return $this->fileName;
	}

    /**
     * @param string
     */
	public function setFileName(string $fileName): void
	{
		$this->fileName = $fileName;
	}

    /**
     * @return VideoCard
     */
	public function getGpu(): VideoCard
	{
		return $this->gpu;
	}

    /**
     * @param VideoCard
     */
	public function setGpu(VideoCard $gpu): void
	{
		$this->gpu = $gpu;
	}
}
