<?php

namespace Podorozhny\Model\Backend;

use Doctrine\Common\Collections\ArrayCollection;

class Role
	implements RoleInterface
{
	protected $id;
	protected $name;
	protected $groups;

	public function __construct($name = null)
	{
		if (!is_null($name)) {
			$this->name = $name;
		}
		$this->groups = new ArrayCollection();
	}

	public function __toString()
	{
		return (string) $this->getName();
	}

	public function getId()
	{
		return $this->id;
	}

	public function setName($name)
	{
		$this->name = strtoupper($name);

		return $this;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getGroups()
	{
		return $this->groups;
	}

	public function getRole()
	{
		return $this->getName();
	}
}