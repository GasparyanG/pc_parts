<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="cooler_images")
 */
class CoolerImage 
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
     * @var Cooler
     * @ManyToOne(targetEntity="Cooler", inversedBy="coolerImages")
     */
	private $cooler;


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
     * @return Cooler
     */
	public function getCooler(): Cooler
	{
		return $this->cooler;
	}

    /**
     * @param Cooler
     */
	public function setCooler(Cooler $cooler): void
	{
		$this->cooler = $cooler;
	}
}
