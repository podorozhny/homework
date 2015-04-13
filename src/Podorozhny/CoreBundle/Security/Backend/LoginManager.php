<?php

namespace Podorozhny\CoreBundle\Security\Backend;

use Podorozhny\Model\Backend\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\RememberMe\RememberMeServicesInterface;
use Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface;

class LoginManager
	implements LoginManagerInterface
{
	private $securityContext;
	private $userChecker;
	private $sessionStrategy;
	private $container;

	public function __construct(
		SecurityContextInterface $context,
		UserCheckerInterface $userChecker,
		SessionAuthenticationStrategyInterface $sessionStrategy,
		ContainerInterface $container
	) {
		$this->securityContext = $context;
		$this->userChecker     = $userChecker;
		$this->sessionStrategy = $sessionStrategy;
		$this->container       = $container;
	}

	final public function loginUser(
		$firewallName,
		UserInterface $user,
		Response $response = null
	) {
		$this->userChecker->checkPostAuth($user);
		$token = $this->createToken($firewallName, $user);
		if ($this->container->isScopeActive('request')) {
			$this->sessionStrategy->onAuthentication(
				$this->container->get('request'),
				$token
			);
			if (null !== $response) {
				$rememberMeServices = null;
				if ($this->container->has(
					'security.authentication.rememberme.services.persistent.'
					. $firewallName
				)
				) {
					$rememberMeServices = $this->container->get(
						'security.authentication.rememberme.services.persistent.'
						. $firewallName
					);
				} elseif ($this->container->has(
					'security.authentication.rememberme.services.simplehash.'
					. $firewallName
				)
				) {
					$rememberMeServices = $this->container->get(
						'security.authentication.rememberme.services.simplehash.'
						. $firewallName
					);
				}
				if ($rememberMeServices instanceof RememberMeServicesInterface
				) {
					$rememberMeServices->loginSuccess(
						$this->container->get('request'),
						$response,
						$token
					);
				}
			}
		}
		$this->securityContext->setToken($token);
	}

	protected function createToken($firewall, UserInterface $user)
	{
		return new UsernamePasswordToken(
			$user, null, $firewall, $user->getRoles()
		);
	}
}