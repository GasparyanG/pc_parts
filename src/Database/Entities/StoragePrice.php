<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="storage_prices")
 */
class StoragePrice 
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
     * @ManyToOne(targetEntity="Retailer", inversedBy="storagePrices")
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
     * @var string
     * @Column(type="string", name="url")
     */
    private $url;

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @var Storage
     * @ManyToOne(targetEntity="Storage", inversedBy="storagePrices")
     */
    private $storage;

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
     * @return Storage
     */
	public function getStorage(): Storage
	{
		return $this->storage;
	}

    /**
     * @param Storage
     */
	public function setStorage(Storage $storage): void
	{
		$this->storage = $storage;
	}
}
