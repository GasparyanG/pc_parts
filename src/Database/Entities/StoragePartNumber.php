<?php


namespace App\Database\Entities;


/**
 * @Entity
 * @Table(name="storage_part_numbers")
 */
class StoragePartNumber
{
    const PART_NUMBER = "part_number";
    const STORAGE = "storage";

    /**
     * @var int
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", name="part_number")
     */
    private $part_number;

    /**
     * @var Storage
     * @ManyToOne(targetEntity="Storage", inversedBy="storage_part_numbers")
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
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPartNumber(): string
    {
        return $this->part_number;
    }

    /**
     * @param string $part_number
     */
    public function setPartNumber(string $part_number): void
    {
        $this->part_number = $part_number;
    }

    /**
     * @return Storage
     */
    public function getStorage(): Storage
    {
        return $this->storage;
    }

    /**
     * @param Storage $storage
     */
    public function setStorage(Storage $storage): void
    {
        $this->storage = $storage;
    }

    public function getEntityId(): int
    {
        return $this->storage->getId();
    }
}