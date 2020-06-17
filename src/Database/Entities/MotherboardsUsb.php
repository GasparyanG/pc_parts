<?php
namespace App\Database\Entities;

/**
 * @Entity
 * @Table(name="motherboards_usbs")
 */
class MotherboardsUsb 
{
    const MOTHERBOARD = "motherboard";
    const USB = "usb";
    const AMOUNT = "amount";

    /**
     * @var Motherboard
     * @ManyToOne(targetEntity="Motherboard", inversedBy="motehrboardsUsbs")
     */
	private $motherboard;

    /**
     * @var Usb
     * @ManyToOne(targetEntity="Usb", inversedBy="motehrboardsUsbs")
     */
	private $usb;

    /**
     * @var int
     * @Column(type="integer", name="amount")
	 */
	private $amount;

    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
	 * @GeneratedValue
	 */
	private $id;

    /**
     * @return Motherboard
     */
	public function getMotherboard(): Motherboard
	{
		return $this->motherboard;
	}

    /**
     * @param Motherboard
     */
	public function setMotherboard(Motherboard $motherboard): void
	{
		$this->motherboard = $motherboard;
	}

    /**
     * @return Usb
     */
	public function getUsb(): Usb
	{
		return $this->usb;
	}

    /**
     * @param Usb
     */
	public function setUsb(Usb $usb): void
	{
		$this->usb = $usb;
	}

    /**
     * @return int
     */
	public function getAmount(): int
	{
		return $this->amount;
	}

    /**
     * @param int
     */
	public function setAmount(int $amount): void
	{
		$this->amount = $amount;
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
}
