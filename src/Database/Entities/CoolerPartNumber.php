<?php


namespace App\Database\Entities;


/**
 * @Entity
 * @Table(name="cooler_part_numbers")
 */
class CoolerPartNumber
{
    const PART_NUMBER = "partNumber";
    const COOLER = "cooler";

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
    private $partNumber;

    /**
     * @var Cooler
     * @ManyToOne(targetEntity="Cooler", inversedBy="cooler_part_numbers")
     */
    private $cooler;

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
        return $this->partNumber;
    }

    /**
     * @param string $partNumber
     */
    public function setPartNumber(string $partNumber): void
    {
        $this->partNumber = $partNumber;
    }

    /**
     * @return Cooler
     */
    public function getCooler(): Cooler
    {
        return $this->cooler;
    }

    /**
     * @param Cooler $cooler
     */
    public function setCooler(Cooler $cooler): void
    {
        $this->cooler = $cooler;
    }

    public function getEntityId(): int
    {
        return $this->cooler->getId();
    }
}