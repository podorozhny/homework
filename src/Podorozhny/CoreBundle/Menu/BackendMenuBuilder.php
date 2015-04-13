<?php

namespace Podorozhny\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\SecurityContextInterface;

class BackendMenuBuilder
{
	protected $factory;
	protected $securityContext;
	protected $request;

	public function __construct(
		FactoryInterface $factory,
		SecurityContextInterface $securityContext,
		RequestStack $requestStack
	) {
		$this->factory         = $factory;
		$this->securityContext = $securityContext;
		$this->requestStack    = $requestStack;
	}

	public function createMainMenu()
	{
		$menu = $this->factory->createItem('root');
		$menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

		$menu->addChild(
			'user',
			[
				'label' => '<i class="fa fa-fw fa-user"></i> ' . $this->securityContext->getToken()
					->getUser()
					->getName()
			]
		)
			->setAttribute('dropdown', true);

		$menu['user']->addChild(
			'Выход',
			['route' => 'backend_security_logout']
		);

		return $menu;
	}

	public function createSidebarMenu()
	{
		$menu = $this->factory->createItem('root');

		$menu->setChildrenAttribute('class', 'nav nav-sidebar');

		$menu->addChild(
			'Главная',
			['route' => 'backend_home']
		);

		if ($this->securityContext->isGranted('ROLE_PERSONNEL')
		) {
			$menu->addChild(
				'Отдел кадров',
				[
					'route'      => 'backend_user_list',
					'attributes' => ['divider_prepend' => true]
				]
			)
				->setCurrent($this->isCurrent(['backend_user_']));
		}

		if ($this->securityContext->isGranted('ROLE_CLIENTS')
		) {
			$menu->addChild(
				'Клиентский отдел',
				[
					'route'      => 'clients_client_list',
					'attributes' => ['divider_prepend' => true]
				]
			)
				->setCurrent($this->isCurrent(['clients_client_']));
		}

		if ($this->securityContext->isGranted('ROLE_FINANCE')
		) {
			$menu->addChild(
				'Финансовый отдел',
				[
					'route'      => 'finance_transaction_list',
					'attributes' => ['divider_prepend' => true]
				]
			)
				->setCurrent($this->isCurrent(['finance_transaction_']));
		}

		if ($this->securityContext->isGranted('ROLE_WAREHOUSE')
		) {
			$menu->addChild(
				'Складской отдел',
				[
					'route'      => 'warehouse_good_list',
					'attributes' => ['divider_prepend' => true]
				]
			)
				->setCurrent($this->isCurrent(['warehouse_good_']));
		}

		return $menu;
	}

	private function isCurrent($routes = array())
	{
		$requestRoute =
			$this->requestStack->getCurrentRequest()
				->get('_route');

		foreach ($routes as $route) {
			if (mb_substr($requestRoute, 0, mb_strlen($route)) === $route) {
				return true;
			}
		}

		return false;
	}
}