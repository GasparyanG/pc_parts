<?php


namespace App\Database\Entities;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="form_factors")
 */
class FormFactor
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
     * @OneToMany(targetEntity="Memory", mappedBy="formFactor")
     */
    private $memories;

    public function __construct()
    {
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
    public function getMemories()
    {
        return $this->memories;
    }

    public function addMemory(Memory $memory): void
    {
        if (!$this->memories->contains($memory)) {
            $this->memories[] = $memory;
            $memory->setFormFactor($this);
        }
    }
}