<?php

namespace Podorozhny\Manager\Backend;

use Podorozhny\Manager\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Podorozhny\Util\CanonicalizerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Podorozhny\Model\Backend\UserInterface;

class UserManager
	extends ObjectManager
	implements UserProviderInterface
{
	protected $encoderFactory;
	protected $emailCanonicalizer;

	public function __construct(
		EntityManager $entityManager,
		EventDispatcherInterface $eventDispatcher,
		$class,
		EncoderFactoryInterface $encoderFactory,
		CanonicalizerInterface $canonicalizer
	) {
		$this->entityManager      = $entityManager;
		$this->eventDispatcher    = $eventDispatcher;
		$this->class              = $class;
		$this->encoderFactory     = $encoderFactory;
		$this->emailCanonicalizer = $canonicalizer;
	}

	public function getEncoderFactory()
	{
		return $this->encoderFactory;
	}

	public function getEmailCanonicalizer()
	{
		return $this->emailCanonicalizer;
	}

	public function findByEmail($email)
	{
		return $this->findOneBy(
			['emailCanonical' => $this->canonicalizeEmail($email)]
		);
	}

	public function findByUsername($username)
	{
		return $this->findByEmail($username);
	}

	public function findByUsernameOrEmail($usernameOrEmail)
	{
		return $this->findByEmail($usernameOrEmail);
	}

	public function refreshUser(SecurityUserInterface $user)
	{
		trigger_error(
			'Using the UserManager as user provider is deprecated. Use Podorozhny\CoreBundle\Security\Backend\UserProvider instead.',
			E_USER_DEPRECATED
		);
		$class = $this->getClass();
		if (!$user instanceof $class) {
			throw new UnsupportedUserException('Account is not supported.');
		}
		if (!$user instanceof User) {
			throw new UnsupportedUserException(
				sprintf(
					'Expected an instance of Podorozhny\Manager\Backend\User, but got "%s".',
					get_class($user)
				)
			);
		}
		$refreshedUser = $this->findUserBy(['id' => $user->getId()]);
		if (null === $refreshedUser) {
			throw new UsernameNotFoundException(
				sprintf(
					'User with ID "%d" could not be reloaded.',
					$user->getId()
				)
			);
		}

		return $refreshedUser;
	}

	public function loadUserByUsername($email)
	{
		return $this->loadUserByEmail($email);
	}

	public function loadUserByEmail($email)
	{
		trigger_error(
			'Using the UserManager as user provider is deprecated. Use Podorozhny\CoreBundle\Security\Backend\UserProvider instead.',
			E_USER_DEPRECATED
		);
		$user = $this->findUserByEmail($email);
		if (!$user) {
			throw new UsernameNotFoundException(
				sprintf('No user with email "%s" was found.', $email)
			);
		}

		return $user;
	}

	public function reloadUser(UserInterface $user)
	{
		$this->getEntityManager()
			->refresh($user);
	}

	public function updateUser(UserInterface $user, $andFlush = true)
	{
		$this->updateCanonicalFields($user);
		$this->updatePassword($user);

		return $this->update($user);
	}

	public function updateCanonicalFields(UserInterface $user)
	{
		$user->setEmailCanonical($this->canonicalizeEmail($user->getEmail()));
	}

	public function updatePassword(UserInterface $user)
	{
		if (0 !== strlen($password = $user->getPlainPassword())) {
			$encoder = $this->getEncoder($user);
			$user->setPassword(
				$encoder->encodePassword($password, $user->getSalt())
			);
			$user->eraseCredentials();
		}
	}

	protected function canonicalizeEmail($email)
	{
		return $this->getEmailCanonicalizer()
			->canonicalize($email);
	}

	protected function getEncoder(UserInterface $user)
	{
		return $this->getEncoderFactory()
			->getEncoder($user);
	}

	public function supportsClass($class)
	{
		trigger_error(
			'Using the UserManager as user provider is deprecated. Use Podorozhny\CoreBundle\Security\Backend\UserProvider instead.',
			E_USER_DEPRECATED
		);

		return $class === $this->getClass();
	}
}