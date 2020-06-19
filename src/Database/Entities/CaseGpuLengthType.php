<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="case_gpu_length_types")
 */
class CaseGpuLengthType 
{
    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
	 * @GeneratedValue
	 */
	private $id;

    /**
     * @var PcCase
     * @ManyToOne(targetEntity="PcCase", inversedBy="caseGpuLengthTypes")
     * @JoinColumn(name="case_id")
     */
	private $case;

    /**
     * @var float
     * @Column(type="float", name="length")
	 */
	private $length;

    /**
     * @var bool
     * @Column(type="boolean", name="cage")
	 */
	private $cage;


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

    /**
     * @return float
     */
	public function getLength(): float
	{
		return $this->length;
	}

    /**
     * @param float
     */
	public function setLength(float $length): void
	{
		$this->length = $length;
	}

    /**
     * @return null|bool
     */
	public function getCage(): ?bool
	{
		return $this->cage;
	}

    /**
     * @param null|bool
     */
	public function setCage(?bool $cage): void
	{
		$this->cage = $cage;
	}
}
