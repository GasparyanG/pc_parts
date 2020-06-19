<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="case_bays")
 */
class CaseBay 
{
    const TYPE = "type";
    const SIZE = "size";
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
     * @var float
     * @Column(type="float", name="size")
	 */
	private $size;

    /**
     * @var int
     * @Column(type="integer", name="amount")
	 */
	private $amount;

    /**
     * @ManyToMany(targetEntity="PcCase", mappedBy="bays")
     * @JoinTable(name="cases_bays",
     *      joinColumns={@JoinColumn(name="bay_id", referencedColumnName="id")},
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
     * @return float
     */
	public function getSize(): float
	{
		return $this->size;
	}

    /**
     * @param float
     */
	public function setSize(float $size): void
	{
		$this->size = $size;
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
            $pcCase->addBay($this);
        }
    }
}
