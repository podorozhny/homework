<?php

namespace Podorozhny\CoreBundle\Security\Backend;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;
use Podorozhny\Model\Backend\User;
use Podorozhny\Manager\ObjectManagerInterface;

class UserProvider
    implements UserProviderInterface
{
    protected $userManager;

    public function __construct(ObjectManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function loadUserByEmail($email)
    {
        $user = $this->findUser($email);
        if (!$user) {
            throw new UsernameNotFoundException(
                sprintf('Username "%s" does not exist.', $email)
            );
        }

        return $user;
    }

    public function loadUserByUsername($email)
    {
        return $this->loadUserByEmail($email);
    }

    public function refreshUser(SecurityUserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf(
                    'Expected an instance of Podorozhny\Model\Backend\User, but got "%s".',
                    get_class($user)
                )
            );
        }
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(
                sprintf(
                    'Expected an instance of %s, but got "%s".',
                    $this->userManager->getClass(),
                    get_class($user)
                )
            );
        }
        if (null ===
            $reloadedUser = $this->userManager->findById($user->getId())
        ) {
            throw new UsernameNotFoundException(
                sprintf(
                    'User with ID "%d" could not be reloaded.',
                    $user->getId()
                )
            );
        }

        return $reloadedUser;
    }

    public function supportsClass($class)
    {
        $userClass = $this->userManager->getClass();

        return $userClass === $class || is_subclass_of($class, $userClass);
    }

    protected function findUser($email)
    {
        return $this->userManager->findByEmail($email);
    }
}