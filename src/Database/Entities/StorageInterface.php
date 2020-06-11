<?php


namespace App\Database\Entities;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="storage_interfaces")
 */
class StorageInterface
{
    const TYPE = "type";

    /**
     * @var int
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", name="type")
     */
    private $type;

    /**
     * @OneToMany(targetEntity="Storage", mappedBy="storageInterface")
     */
    private $storages;

    public function __construct()
    {
        $this->storages = new ArrayCollection();
    }

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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getStorages()
    {
        return $this->storages;
    }

    public function addStorage(Storage $storage): void
    {
        if (!$this->storages->contains($storage)) {
            $this->storages[] = $storage;
            $storage->setStorageInterface($this);
        }
    }
}