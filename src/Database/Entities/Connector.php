<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="connectors")
 */
class Connector 
{
    const TYPE = "type";

    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
	 * @GeneratedValue
	 */
	private $id;

    /**
     * @var string
     * @Column(type="string", name="type")
	 */
	private $type;


	/**
     * @OneToMany(targetEntity="PsuConnector", mappedBy="connector")
	 */
	private $psuConnectors;

	public function __construct()
    {
        $this->psuConnectors = new ArrayCollection();
    }

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
	public function getType(): string
	{
		return $this->type;
	}

    /**
     * @param string
     */
	public function setType(string $type): void
	{
		$this->type = $type;
	}

    /**
     * @return mixed
     */
    public function getPsuConnectors()
    {
        return $this->psuConnectors;
    }

    /**
     * @param PsuConnector
     */
    public function addPsuConnector(PsuConnector $psuConnector): void
    {
        if (!$this->psuConnectors->contains($psuConnector)) {
            $this->psuConnectors[] = $psuConnector;
            $psuConnector->setConnector($this);
        }
    }
}
