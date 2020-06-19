<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="case_types")
 */
class CaseType 
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
     * @Column(type="string", name="type")
	 */
	private $type;

    /**
     * @OneToMany(targetEntity="PcCase", mappedBy="manufacturer")
     */
    private $pcCases;

    public function __construct()
    {
        $this->pcCases = new ArrayCollection();
    }

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
	public function getType(): string
	{
		return $this->type;
	}

    /**
     * @param string
     */
	public function setType(string $type): void
	{
		$this->type = $type;
	}

    /**
     * @return mixed
     */
    public function getPcCases()
    {
        return $this->pcCases;
    }

    /**
     * @param PcCase $pcCase
     */
    public function addPcCase(PcCase $pcCase): void
    {
        if (!$this->pcCases->contains($pcCase)) {
            $this->pcCases[] = $pcCase;
            $pcCase->setCaseType($this);
        }
    }
}
