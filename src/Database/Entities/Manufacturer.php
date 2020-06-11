<?php

namespace App\Database\Entities;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="manufacturers")
 */
class Manufacturer
{
    const NAME = "name";

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
     * @OneToMany(targetEntity="Cooler", mappedBy="manufacturer")
     */
    private $coolers;

    /**
     * @OneToMany(targetEntity="Memory", mappedBy="manufacturer")
     */
    private $memories;

    /**
     * @OneToMany(targetEntity="Cpu", mappedBy="manufacturer")
     */
    private $cpus;

    /**
     * @OneToMany(targetEntity="Storage", mappedBy="manufacturer")
     */
    private $storages;

    public function __construct()
    {
        $this->coolers = new ArrayCollection();
        $this->memories = new ArrayCollection();
        $this->cpus = new ArrayCollection();
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
     * @return mixed
     */
    public function getCoolers()
    {
        return $this->coolers;
    }

    public function addCooler(Cooler $cooler): void
    {
        if (!$this->coolers->contains($cooler)) {
            $this->coolers[] = $cooler;
            $cooler->setManufacturer($this);
        }
    }

    /**
     * @return mixed
     */
    public function getMemories()
    {
        return $this->memories;
    }

    public function addMemory(Memory $memory): void
    {
        if (!$this->memories->contains($memory)) {
            $this->memories[] = $memory;
            $memory->setManufacturer($this);
        }
    }

    /**
     * @return mixed
     */
    public function getCpus()
    {
        return $this->cpus;
    }

    /**
     * @param Cpu
     */
    public function addCpu(Cpu $cpu): void
    {
        if (!$this->cpus->contains($cpu)) {
            $this->cpus[] = $cpu;
            $cpu->setManufacturer($this);
        }
    }

    /**
     * @return mixed
     */
    public function getStorages()
    {
        return $this->storages;
    }

    /**
     * @param Storage
     */
    public function addStorage(Storage $storage): void
    {
        if (!$this->storages->contains($storage)) {
            $this->storages[] = $storage;
            $storage->setManufacturer($this);
        }
    }
}
