<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="mobo_form_factors")
 */
class MoboFormFactor 
{
    const TYPE = "type";

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
     * @OneToMany(targetEntity="Motherboard", mappedBy="moboFormFactor")
     */
    private $motherboards;

    /**
     * @ManyToMany(targetEntity="PcCase", mappedBy="formFactors")
     * @JoinTable(name="cases_form_factors",
     *      joinColumns={@JoinColumn(name="mobo_form_factor_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="case_id", referencedColumnName="id")}
     *      )
     */
    private $cases;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->cases = new ArrayCollection();
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
    public function getMotherboards()
    {
        return $this->motherboards;
    }

    /**
     * @param Motherboard
     */
    public function addMotherboard(Motherboard $motherboard): void
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->setMoboFormFactor($this);
        }
    }

    /**
     * @return mixed
     */
    public function getCases()
    {
        return $this->cases;
    }

    /**
     * @param PcCase $pcCase
     */
    public function addCase(PcCase $pcCase): void
    {
        if (!$this->cases->contains($pcCase)) {
            $this->cases[] = $pcCase;
            $pcCase->addFormFactor($this);
        }
    }
}
