<?php


namespace App\Database\Entities;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="colors")
 */
class Color
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
     * @ManyToMany(targetEntity="Cooler", inversedBy="colors")
     * @JoinTable(name="coolers_colors")
     */
    private $coolers;

    /**
     * @ManyToMany(targetEntity="Memory", inversedBy="colors")
     * @JoinTable(name="memories_colors")
     */
    private $memories;

    public function __construct()
    {
        $this->coolers = new ArrayCollection();
        $this->memories = new ArrayCollection();
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
            $cooler->addColor($this);
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
            $memory->addColor($this);
        }
    }
}