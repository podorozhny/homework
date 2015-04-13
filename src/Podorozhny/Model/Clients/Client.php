<?php

namespace Podorozhny\Model\Clients;

class Client
	implements ClientInterface
{
	protected $id;
	protected $createdAt;
	protected $name;
	protected $phone;
	protected $email;
	protected $notes;

	public function __construct()
	{
		$this->createdAt = new \DateTime();
	}

	public function __toString()
	{
		return $this->getName();
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

	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setPhone($phone)
	{
		$this->phone = $phone;

		return $this;
	}

	public function getPhone()
	{
		return $this->phone;
	}

	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setNotes($notes)
	{
		$this->notes = $notes;

		return $this;
	}

	public function getNotes()
	{
		return $this->notes;
	}

	public function convertPhone()
	{
		$phone = $this->getPhone();
		
		if ($phone) {
			list($code, $block1, $block2, $block3) =
				sscanf($phone, "+7 (%d) %d-%d-%d");
			$phone = $code . $block1 . $block2 . $block3;
			$this->setPhone(!empty($phone) ? $phone : null);
		}
	}
}