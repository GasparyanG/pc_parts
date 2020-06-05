<?php


namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="bearing_types")
 */
class BearingType
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
     * @OneToMany(targetEntity="Cooler", mappedBy="bearingType")
     */
    private $coolers;

    public function __construct()
    {
        $this->coolers = new ArrayCollection();
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
    public function getCoolers()
    {
        return $this->coolers;
    }

    public function addCooler(Cooler $cooler): void
    {
        if (!$this->coolers->contains($cooler)) {
            $this->coolers[] = $cooler;
            $cooler->setBearingType($this);
        }
    }
}