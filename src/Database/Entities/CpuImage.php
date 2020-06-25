<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="cpu_images")
 */
class CpuImage 
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
     * @var Cpu
     * @ManyToOne(targetEntity="Cpu", inversedBy="cpuImages")
     */
	private $cpu;


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
     * @return Cpu
     */
	public function getCpu(): Cpu
	{
		return $this->cpu;
	}

    /**
     * @param Cpu
     */
	public function setCpu(Cpu $cpu): void
	{
		$this->cpu = $cpu;
	}
}
