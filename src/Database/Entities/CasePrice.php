<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="case_prices")
 */
class CasePrice 
{
    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
	 * @GeneratedValue
	 */
	private $id;

    /**
     * @var Retailer
     * @ManyToOne(targetEntity="Retailer", inversedBy="casePrices")
     */
    private $retailer;

    /**
     * @var float
     * @Column(type="float", name="price")
	 */
	private $price;

    /**
     * @var int
     * @Column(type="integer", name="date")
	 */
	private $date;

    /**
     * @var PcCase
     * @ManyToOne(targetEntity="PcCase", inversedBy="casePrices")
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
     * @return Retailer
     */
	public function getRetailer(): Retailer
	{
		return $this->retailer;
	}

    /**
     * @param Retailer
     */
	public function setRetailer(Retailer $retailer): void
	{
		$this->retailer = $retailer;
	}

    /**
     * @return null|float
     */
	public function getPrice(): ?float
	{
		return $this->price;
	}

    /**
     * @param null|float
     */
	public function setPrice(?float $price): void
	{
		$this->price = $price;
	}

    /**
     * @return int
     */
	public function getDate(): int
	{
		return $this->date;
	}

    /**
     * @param int
     */
	public function setDate(int $date): void
	{
		$this->date = $date;
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
