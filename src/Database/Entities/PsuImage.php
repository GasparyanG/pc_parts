<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="psu_images")
 */
class PsuImage 
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
     * @var PowerSupply
     * @ManyToOne(targetEntity="PowerSupply", inversedBy="psuImages")
     */
	private $psu;


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
     * @return PowerSupply
     */
	public function getPsu(): PowerSupply
	{
		return $this->psu;
	}

    /**
     * @param PowerSupply
     */
	public function setPsu(PowerSupply $psu): void
	{
		$this->psu = $psu;
	}
}
