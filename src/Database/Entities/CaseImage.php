<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="case_images")
 */
class CaseImage 
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
     * @var PcCase
     * @ManyToOne(targetEntity="PcCase", inversedBy="caseImages")
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
