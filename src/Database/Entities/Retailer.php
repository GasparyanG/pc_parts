<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="retailers")
 */
class Retailer 
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
     * @Column(type="string", name="url")
	 */
	private $url;

    /**
     * @var string
     * @Column(type="string", name="name")
	 */
	private $name;

    /**
     * @var string
     * @Column(type="string", name="logo_file_name")
	 */
	private $logoFileName;

    /**
     * @var int
     * @Column(type="integer", name="added")
	 */
	private $added;

	/**
     * @OneToMany(targetEntity="PsuPrice", mappedBy="retailer")
	 */
	private $psuPrices;

	/**
     * @OneToMany(targetEntity="StoragePrice", mappedBy="retailer")
	 */
	private $storagePrices;

	public function __construct()
    {
        $this->psuPrices = new ArrayCollection();
        $this->storagePrices = new ArrayCollection();
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
	public function getUrl(): string
	{
		return $this->url;
	}

    /**
     * @param string
     */
	public function setUrl(string $url): void
	{
		$this->url = $url;
	}

    /**
     * @return string
     */
	public function getName(): string
	{
		return $this->name;
	}

    /**
     * @param string
     */
	public function setName(string $name): void
	{
		$this->name = $name;
	}

    /**
     * @return string
     */
	public function getLogoFileName(): string
	{
		return $this->logoFileName;
	}

    /**
     * @param string
     */
	public function setLogoFileName(string $logoFileName): void
	{
		$this->logoFileName = $logoFileName;
	}

    /**
     * @return int
     */
	public function getAdded(): int
	{
		return $this->added;
	}

    /**
     * @param int
     */
	public function setAdded(int $added): void
	{
		$this->added = $added;
	}

    /**
     * @return mixed
     */
    public function getPsuPrices()
    {
        return $this->psuPrices;
    }

    /**
     * @param PsuPrice $psuPrice
     */
    public function addPsuPrice(PsuPrice $psuPrice): void
    {
        if (!$this->psuPrices->contains($psuPrice)) {
            $this->psuPrices[] = $psuPrice;
            $psuPrice->setRetailer($this);
        }
    }

    /**
     * @return mixed
     */
    public function getStoragePrices()
    {
        return $this->storagePrices;
    }

    /**
     * @param StoragePrice $storagePrice
     */
    public function addStoragePrice(StoragePrice $storagePrice): void
    {
        if (!$this->storagePrices->contains($storagePrice)) {
            $this->storagePrices[] = $storagePrice;
            $storagePrice->setRetailer($this);
        }
    }
}
