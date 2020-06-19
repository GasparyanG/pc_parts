<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="expansion_slots")
 */
class ExpansionSlot 
{
    const TYPE = "type";
    const AMOUNT = "amount";

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
     * @var int
     * @Column(type="integer", name="amount")
	 */
	private $amount;

    /**
     * @ManyToMany(targetEntity="PcCase", mappedBy="expansionSlots")
     * @JoinTable(name="cases_expansion_slots",
     *      joinColumns={@JoinColumn(name="expansion_slot_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="case_id", referencedColumnName="id")}
     *      )
     */
    private $cases;

	public function __construct()
    {
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
     * @return int
     */
	public function getAmount(): int
	{
		return $this->amount;
	}

    /**
     * @param int
     */
	public function setAmount(int $amount): void
	{
		$this->amount = $amount;
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
            $pcCase->addExpansionSlot($this);
        }
    }
}
