<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="storage_images")
 */
class StorageImage 
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
     * @Column(type="string", name="file_name")
	 */
	private $fileName;

    /**
     * @var Storage
     * @ManyToOne(targetEntity="Storage", inversedBy="storageImages")
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
     * @return string
     */
	public function getFileName(): string
	{
		return $this->fileName;
	}

    /**
     * @param string
     */
	public function setFileName(string $fileName): void
	{
		$this->fileName = $fileName;
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
