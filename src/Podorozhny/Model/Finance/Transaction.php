<?php

namespace Podorozhny\Model\Finance;

class Transaction
	implements TransactionInterface
{
	protected $id;
	protected $createdAt;
	protected $title;
	protected $description;
	protected $amount;

	public function __construct()
	{
		$this->createdAt = new \DateTime();
		$this->amount    = 0;
	}

	public function __toString()
	{
		return (string) $this->getTitle();
	}

	public function getId()
	{
		return $this->id;
	}

	public function setCreatedAt(\DateTime $date = null)
	{
		$this->createdAt = $date;

		return $this;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setAmount($amount)
	{
		$this->amount = (int) $amount;

		return $this;
	}

	public function getAmount()
	{
		return $this->amount;
	}
}