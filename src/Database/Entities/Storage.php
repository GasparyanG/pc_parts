<?php


namespace App\Database\Entities;


/**
 * @Entity
 * @Table(name="storages")
 */
class Storage
{
    /**
     * @var int
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", name="name")
     */
    private $name;

    /**
     * @var string
     * @Column(type="string", name="url")
     */
    private $url;

    /**
     * @var float
     * @Column(type="float", name="capacity")
     */
    private $capacity;

    /**
     * @var float|null
     * @Column(type="float", name="cache")
     */
    private $cache;

    /**
     * @var bool|null
     * @Column(type="boolean", name="nvme")
     */
    private $nvme;

    /**
     * @var Manufacturer
     * @ManyToOne(targetEntity="Manufacturer", inversedBy="storages")
     */
    private $manufacturer;

    /**
     * @var StorageType
     * @ManyToOne(targetEntity="StorageType", inversedBy="storages")
     * @JoinColumn(name="storage_type_id")
     */
    private $storageType;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return float
     */
    public function getCapacity(): float
    {
        return $this->capacity;
    }

    /**
     * @param float $capacity
     */
    public function setCapacity(float $capacity): void
    {
        $this->capacity = $capacity;
    }

    /**
     * @return float|null
     */
    public function getCache(): ?float
    {
        return $this->cache;
    }

    /**
     * @param float|null $cache
     */
    public function setCache(?float $cache): void
    {
        $this->cache = $cache;
    }

    /**
     * @return bool|null
     */
    public function getNvme(): ?bool
    {
        return $this->nvme;
    }

    /**
     * @param bool|null $nvme
     */
    public function setNvme(?bool $nvme): void
    {
        $this->nvme = $nvme;
    }

    /**
     * @return Manufacturer
     */
    public function getManufacturer(): Manufacturer
    {
        return $this->manufacturer;
    }

    /**
     * @param Manufacturer $manufacturer
     */
    public function setManufacturer(Manufacturer $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return StorageType
     */
    public function getStorageType(): StorageType
    {
        return $this->storageType;
    }

    /**
     * @param StorageType $storageType
     */
    public function setStorageType(StorageType $storageType): void
    {
        $this->storageType = $storageType;
    }
}
