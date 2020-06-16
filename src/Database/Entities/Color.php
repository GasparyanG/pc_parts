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

    /**
     * @ManyToMany(targetEntity="PowerSupply", mappedBy="colors")
     * @JoinTable(name="psus_colors",
     *      joinColumns={@JoinColumn(name="color_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="power_supply_id", referencedColumnName="id")}
     *      )
     */
    private $powerSupplies;

    /**
     * @ManyToMany(targetEntity="Motherboard", mappedBy="colors")
     * @JoinTable(name="motherboards_colors",
     *      joinColumns={@JoinColumn(name="color_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="motherboard_id", referencedColumnName="id")}
     *      )
     */
    private $motherboards;


    public function __construct()
    {
        $this->coolers = new ArrayCollection();
        $this->memories = new ArrayCollection();
        $this->powerSupplies = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
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

    /**
     * @return mixed
     */
    public function getPowerSupplies()
    {
        return $this->powerSupplies;
    }

    public function addPowerSupply(PowerSupply $powerSupply): void
    {
        if (!$this->powerSupplies->contains($powerSupply)) {
            $this->powerSupplies[] = $powerSupply;
            $powerSupply->addColor($this);
        }
    }

    /**
     * @return mixed
     */
    public function getMotherboards()
    {
        return $this->motherboards;
    }

    public function addMotherboard(Motherboard $motherboard): void
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->addColor($this);
        }
    }
}