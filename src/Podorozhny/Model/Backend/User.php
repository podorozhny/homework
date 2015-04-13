<?php

namespace Podorozhny\Model\Backend;

class User
	implements UserInterface
{
	protected $id;
	protected $createdAt;
	protected $username; // TODO deprecated
	protected $email;
	protected $emailCanonical;
	protected $password;
	protected $plainPassword;
	protected $salt;
	protected $group;
	protected $roles; // TODO deprecated
	protected $name;

	public function __construct()
	{
		$this->createdAt = new \DateTime();
		$this->salt      =
			md5(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
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

	/**
	 * @deprecated
	 */
	public function getUsername()
	{
		return $this->getEmail();
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

	public function setEmailCanonical($emailCanonical)
	{
		$this->emailCanonical = $emailCanonical;

		return $this;
	}

	public function getEmailCanonical()
	{
		return $this->emailCanonical;
	}

	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setPlainPassword($password)
	{
		$this->plainPassword = $password;

		return $this;
	}

	public function getPlainPassword()
	{
		return $this->plainPassword;
	}

	public function setSalt($salt)
	{
		$this->salt = $salt;

		return $this;
	}

	public function getSalt()
	{
		return $this->salt;
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

	public function setGroup(UserGroupInterface $group)
	{
		$this->group = $group;

		return $this;
	}

	public function getGroup()
	{
		return $this->group;
	}

	public function getRoles()
	{
		return array_merge(
			[self::ROLE_DEFAULT],
			$this->getGroup()
				->getRoleNames()
		);
	}

	public function hasRole($role)
	{
		return in_array(strtoupper($role), $this->getRoles(), true);
	}

	public function isUser(UserInterface $user = null)
	{
		return null !== $user && $this->getId() === $user->getId();
	}

	/**
	 * @deprecated
	 */
	public function setSuperAdmin($boolean)
	{
		return $this;
	}

	/**
	 * @deprecated
	 */
	public function isSuperAdmin()
	{
		return false;
	}

	public function serialize()
	{
		return serialize(
			[
				$this->id,
				$this->createdAt,
				$this->email,
				$this->password,
				$this->salt,
			]
		);
	}

	public function unserialize($serialized)
	{
		$data = unserialize($serialized);
		list($this->id, $this->createdAt, $this->email, $this->password,
			$this->salt) = $data;
	}

	public function eraseCredentials()
	{
		$this->plainPassword = null;
	}

	public function isAccountNonExpired()
	{
		return true;
	}

	public function isAccountNonLocked()
	{
		return true;
	}

	public function isCredentialsNonExpired()
	{
		return true;
	}

	public function isCredentialsExpired()
	{
		return false;
	}

	public function isEnabled()
	{
		return true;
	}
}