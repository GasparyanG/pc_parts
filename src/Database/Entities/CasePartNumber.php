<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="case_part_numbers")
 */
class CasePartNumber 
{
    const PART_NUMBER = "partNumber";
    const CASE = "case";

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
     * @var PcCase
     * @ManyToOne(targetEntity="PcCase", inversedBy="casePartNumbers")
     * @JoinColumn(name="case_id")
     */
	private $case;


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
     * @return PcCase
     */
	public function getCase(): PcCase
	{
		return $this->case;
	}

    /**
     * @param PcCase
     */
	public function setCase(PcCase $case): void
	{
		$this->case = $case;
	}
}
