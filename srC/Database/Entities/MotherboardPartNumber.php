<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="motherboard_part_numbers")
 */
class MotherboardPartNumber 
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
     * @Column(type="string", name="part_number")
	 */
	private $partNumber;

    /**
     * @var Motherboard
     * @ManyToOne(targetEntity="Motherboard", inversedBy="motherboardPartNumbers")
     */
	private $motherboard;

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
     * @return Motherboard
     */
	public function getMotherboard(): Motherboard
	{
		return $this->motherboard;
	}

    /**
     * @param Motherboard
     */
	public function setMotherboard(Motherboard $motherboard): void
	{
		$this->motherboard = $motherboard;
	}
}
