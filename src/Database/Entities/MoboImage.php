<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="mobo_images")
 */
class MoboImage 
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
     * @var Motherboard
     * @ManyToOne(targetEntity="Motherboard", inversedBy="moboImages")
     */
	private $mobo;


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
     * @return Motherboard
     */
	public function getMobo(): Motherboard
	{
		return $this->mobo;
	}

    /**
     * @param Motherboard
     */
	public function setMobo(Motherboard $mobo): void
	{
		$this->mobo = $mobo;
	}
}
