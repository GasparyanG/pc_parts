<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="memory_images")
 */
class MemoryImage 
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
     * @var Memory
     * @ManyToOne(targetEntity="Memory", inversedBy="memoryImages")
     */
	private $memory;


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
     * @return Memory
     */
	public function getMemory(): Memory
	{
		return $this->memory;
	}

    /**
     * @param Memory
     */
	public function setMemory(Memory $memory): void
	{
		$this->memory = $memory;
	}
}
