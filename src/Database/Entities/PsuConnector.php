<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="psu_connectors")
 */
class PsuConnector 
{
    const AMOUNT = "amount";
    const CONNECTOR = "connector";
    const POWER_SUPPLY = "powerSupply";

    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
	 * @GeneratedValue
	 */
	private $id;

    /**
     * @var PowerSupply
     * @ManyToOne(targetEntity="PowerSupply", inversedBy="psuConnectors")
     * @JoinColumn(name="power_supply_id")
     */
	private $powerSupply;

    /**
     * @var Connector
     * @ManyToOne(targetEntity="Connector", inversedBy="psuConnectors")
     */
	private $connector;

    /**
     * @var int
     * @Column(type="integer", name="amount")
	 */
	private $amount;


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
     * @return PowerSupply
     */
	public function getPowerSupply(): PowerSupply
	{
		return $this->powerSupply;
	}

    /**
     * @param PowerSupply
     */
	public function setPowerSupply(PowerSupply $powerSupply): void
	{
		$this->powerSupply = $powerSupply;
	}

    /**
     * @return Connector
     */
	public function getConnector(): Connector
	{
		return $this->connector;
	}

    /**
     * @param Connector
     */
	public function setConnector(Connector $connector): void
	{
		$this->connector = $connector;
	}

    /**
     * @return null|int
     */
	public function getAmount(): ?int
	{
		return $this->amount;
	}

    /**
     * @param null|int
     */
	public function setAmount(?int $amount): void
	{
		$this->amount = $amount;
	}
}
